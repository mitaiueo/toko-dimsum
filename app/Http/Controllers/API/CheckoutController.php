<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
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
     * Process checkout and generate payment token
     */
    public function process(Request $request)
    {
        $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
        ]);
        
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)
            ->where('is_active', true)
            ->first();
            
        if (!$cart || $cart->items->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty',
            ], 422);
        }
        
        try {
            DB::beginTransaction();
            
            // Calculate total amount
            $cartItems = $cart->items()->with('product')->get();
            $totalAmount = $cartItems->sum(function ($item) {
                return $item->price * $item->quantity;
            });
            
            // Create transaction
            $order_number = 'ORD-' . time() . '-' . $user->id;
            
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'order_number' => $order_number,
                'total_amount' => $totalAmount,
                'payment_method' => 'midtrans',
                'payment_status' => 'pending',
                'shipping_name' => $request->shipping_name,
                'shipping_phone' => $request->shipping_phone,
                'shipping_address' => $request->shipping_address,
                'shipping_status' => 'pending',
                'notes' => $request->notes ?? null,
            ]);
            
            // Create transaction items
            foreach ($cartItems as $item) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->price * $item->quantity,
                ]);
            }
            
            // Set up Midtrans payment
            $payload = [
                'transaction_details' => [
                    'order_id' => $order_number,
                    'gross_amount' => (int) $totalAmount,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $request->shipping_phone,
                    'billing_address' => [
                        'first_name' => $request->shipping_name,
                        'phone' => $request->shipping_phone,
                        'address' => $request->shipping_address,
                    ],
                ],
                'item_details' => $cartItems->map(function ($item) {
                    return [
                        'id' => $item->product_id,
                        'price' => (int) $item->price,
                        'quantity' => $item->quantity,
                        'name' => $item->product->name,
                    ];
                })->toArray(),
            ];
            
            // Get Snap token
            $snapToken = Snap::getSnapToken($payload);
            $transaction->midtrans_snap_token = $snapToken;
            $transaction->save();
            
            // Mark cart as inactive
            $cart->update(['is_active' => false]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Checkout successful',
                'data' => [
                    'transaction_id' => $transaction->id,
                    'order_number' => $transaction->order_number,
                    'snap_token' => $snapToken,
                ],
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Checkout failed: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    /**
     * Check the status of a transaction
     */
    public function status($id)
    {
        $transaction = Transaction::with('items')->findOrFail($id);
        
        // Ensure the transaction belongs to the current user
        if ($transaction->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access',
            ], 403);
        }
        
        return response()->json([
            'success' => true,
            'data' => $transaction,
        ]);
    }
}
