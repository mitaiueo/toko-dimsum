<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
        
        // Set up Midtrans configuration for direct use if needed
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    }

    /**
     * Show the checkout form
     */
    public function index()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)
            ->where('is_active', true)
            ->first();
            
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('menu')
                ->with('error', 'Your cart is empty. Please add some items before checkout.');
        }
        
        $cartItems = $cart->items()->with('product')->get();
        
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        
        return view('checkout.index', compact('cartItems', 'totalPrice', 'user'));
    }
    
    /**
     * Process the checkout
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
            return redirect()->route('menu')
                ->with('error', 'Your cart is empty. Please add some items before checkout.');
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
            
            // Get Snap token using the Midtrans service
            $snapToken = $this->midtransService->createSnapToken($transaction);
            $transaction->midtrans_snap_token = $snapToken;
            $transaction->save();
            
            // Mark cart as inactive
            $cart->update(['is_active' => false]);
            
            DB::commit();
            
            return view('checkout.payment', compact('transaction', 'snapToken'));
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('checkout.index')
                ->with('error', 'Checkout failed: ' . $e->getMessage());
        }
    }
    
    /**
     * Show payment page for an existing transaction
     */
    public function payment(Transaction $transaction)
    {
        // Ensure the transaction belongs to current user
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }
        
        // Only allow payment for pending transactions
        if ($transaction->payment_status !== 'pending') {
            return redirect()->route('transactions.show', $transaction->id)
                ->with('error', 'This transaction does not require payment.');
        }
        
        // Check if we need to generate a new snap token (if it doesn't exist or is expired)
        if (!$transaction->midtrans_snap_token) {
            try {
                // Load the items relationship if not loaded
                if (!$transaction->relationLoaded('items')) {
                    $transaction->load('items');
                }
                
                $snapToken = $this->midtransService->createSnapToken($transaction);
                $transaction->midtrans_snap_token = $snapToken;
                $transaction->save();
            } catch (\Exception $e) {
                return redirect()->route('transactions.show', $transaction->id)
                    ->with('error', 'Failed to create payment: ' . $e->getMessage());
            }
        }
        
        return view('checkout.payment', [
            'transaction' => $transaction,
            'snapToken' => $transaction->midtrans_snap_token
        ]);
    }
    
    /**
     * Show success page after successful payment
     */
    public function success(Transaction $transaction)
    {
        // Ensure the transaction belongs to current user
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('checkout.success', compact('transaction'));
    }
    
    /**
     * Handle payment notification from Midtrans
     */
    public function notification(Request $request)
    {
        $notificationBody = json_decode($request->getContent(), true);
        $this->midtransService->handleNotification($notificationBody);
        return response()->json(['status' => 'success']);
    }
    
    /**
     * Process direct checkout from product page
     */
    public function directCheckout(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        
        $user = Auth::user();
        
        try {
            DB::beginTransaction();
            
            // Deactivate any existing active cart
            Cart::where('user_id', $user->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
                
            // Create new cart with just this product
            $cart = Cart::create([
                'user_id' => $user->id,
                'is_active' => true,
            ]);
            
            // Add the product to cart
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price,
            ]);
            
            DB::commit();
            
            // Redirect to checkout page
            return redirect()->route('checkout.index');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Could not process your request: ' . $e->getMessage());
        }
    }
    
    /**
     * Update payment status from client side
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'status' => 'required|string',
            'midtrans_transaction_id' => 'nullable|string',
            'result' => 'required|string',
        ]);
        
        $transaction = Transaction::findOrFail($request->transaction_id);
        
        // Ensure the transaction belongs to the current user
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }
        
        // Parse the result
        $result = json_decode($request->result, true);
        
        try {
            DB::beginTransaction();
            
            // Update the transaction
            if ($request->status === 'success') {
                $transaction->payment_status = 'paid';
                $transaction->shipping_status = 'processing';
            }
            
            // Store Midtrans transaction ID
            if (!empty($request->midtrans_transaction_id)) {
                $transaction->midtrans_transaction_id = $request->midtrans_transaction_id;
            } else if (isset($result['transaction_id'])) {
                $transaction->midtrans_transaction_id = $result['transaction_id'];
            }
            
            $transaction->save();
            
            DB::commit();
            
            return redirect()->route('checkout.success', $transaction->id)
                ->with('success', 'Payment successful! Your order is being processed.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('checkout.success', $transaction->id)
                ->with('error', 'Error updating payment status: ' . $e->getMessage());
        }
    }
}
