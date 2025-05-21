<?php

namespace App\Services;

use App\Models\Transaction;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class MidtransService
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }
    
    /**
     * Create Snap payment token
     *
     * @param Transaction $transaction
     * @return string
     */
    public function createSnapToken(Transaction $transaction)
    {
        $items = $transaction->items->map(function ($item) {
            return [
                'id' => $item->product_id,
                'price' => (int) $item->price,
                'quantity' => $item->quantity,
                'name' => $item->product_name,
            ];
        })->toArray();
        
        $payload = [
            'transaction_details' => [
                'order_id' => $transaction->order_number,
                'gross_amount' => (int) $transaction->total_amount,
            ],
            'customer_details' => [
                'first_name' => $transaction->user->name,
                'email' => $transaction->user->email,
                'phone' => $transaction->shipping_phone,
                'billing_address' => [
                    'first_name' => $transaction->shipping_name,
                    'phone' => $transaction->shipping_phone,
                    'address' => $transaction->shipping_address,
                ],
            ],
            'item_details' => $items,
        ];
        
        return Snap::getSnapToken($payload);
    }
    
    /**
     * Handle payment notification from Midtrans
     *
     * @param array $notificationData
     * @return Transaction
     */
    public function handleNotification(array $notificationData)
    {
        $transactionStatus = $notificationData['transaction_status'] ?? null;
        $fraudStatus = $notificationData['fraud_status'] ?? null;
        $orderId = $notificationData['order_id'] ?? null;
        $transactionId = $notificationData['transaction_id'] ?? null;
        
        // Log the notification for debugging
        \Illuminate\Support\Facades\Log::info('Midtrans Notification', $notificationData);
        
        if (!$orderId) {
            \Illuminate\Support\Facades\Log::error('Midtrans notification missing order_id', $notificationData);
            throw new \Exception('Invalid notification: missing order_id');
        }
        
        $transaction = Transaction::where('order_number', $orderId)->first();
        
        if (!$transaction) {
            \Illuminate\Support\Facades\Log::error('Transaction not found for order_id: ' . $orderId);
            throw new \Exception('Transaction not found for order: ' . $orderId);
        }
        
        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $transaction->payment_status = 'pending';
            } else if ($fraudStatus == 'accept') {
                $transaction->payment_status = 'paid';
                $transaction->shipping_status = 'processing';
            }
        } else if ($transactionStatus == 'settlement') {
            $transaction->payment_status = 'paid';
            $transaction->shipping_status = 'processing';
        } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            $transaction->payment_status = 'failed';
        } else if ($transactionStatus == 'pending') {
            $transaction->payment_status = 'pending';
        }
        
        // Save transaction ID
        if ($transactionId) {
            $transaction->midtrans_transaction_id = $transactionId;
        }
        
        $transaction->save();
        
        return $transaction;
    }
}