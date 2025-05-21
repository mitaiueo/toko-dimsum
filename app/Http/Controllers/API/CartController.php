<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display the user's cart contents.
     */
    public function index()
    {
        $user = Auth::user();
        $cart = $this->getCart();
        $cartItems = $cart->items()->with('product')->get();
        
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        
        return response()->json([
            'success' => true,
            'data' => [
                'items' => $cartItems,
                'total_price' => $totalPrice,
                'item_count' => $cartItems->sum('quantity'),
            ],
        ]);
    }
    
    /**
     * Add a product to the cart.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
        
        $product = Product::findOrFail($request->product_id);
        $cart = $this->getCart();
        
        // Check if the product is already in the cart
        $existingItem = $cart->items()->where('product_id', $product->id)->first();
        
        if ($existingItem) {
            // Update quantity if product already exists in cart
            $existingItem->update([
                'quantity' => $existingItem->quantity + $request->quantity,
            ]);
            
            $cartItem = $existingItem;
        } else {
            // Add new item to cart
            $cartItem = $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price,
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully!',
            'data' => $cartItem->load('product'),
        ]);
    }
    
    /**
     * Update cart item quantity.
     */
    public function update(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id',
            'quantity' => 'required|integer|min:1',
        ]);
        
        $cartItem = CartItem::findOrFail($request->cart_item_id);
        
        // Ensure the cart item belongs to the current user
        if ($cartItem->cart->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access',
            ], 403);
        }
        
        $cartItem->update([
            'quantity' => $request->quantity,
        ]);
        
        // Recalculate cart totals
        $cart = $cartItem->cart;
        $cartItems = $cart->items()->with('product')->get();
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        
        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully!',
            'data' => [
                'item' => $cartItem->load('product'),
                'total_price' => $totalPrice,
                'item_count' => $cartItems->sum('quantity'),
            ],
        ]);
    }
    
    /**
     * Remove an item from the cart.
     */
    public function remove($id)
    {
        $cartItem = CartItem::findOrFail($id);
        
        // Ensure the cart item belongs to the current user
        if ($cartItem->cart->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access',
            ], 403);
        }
        
        $cartItem->delete();
        
        // Recalculate cart totals
        $cart = $cartItem->cart;
        $cartItems = $cart->items()->with('product')->get();
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        
        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart!',
            'data' => [
                'total_price' => $totalPrice,
                'item_count' => $cartItems->sum('quantity'),
            ],
        ]);
    }
    
    /**
     * Get the count of items in the cart.
     */
    public function getCartItemCount()
    {
        $cart = $this->getCart();
        $count = $cart->items()->sum('quantity');
        
        return response()->json([
            'success' => true,
            'data' => [
                'count' => $count,
            ],
        ]);
    }
    
    /**
     * Get the current user's active cart or create a new one.
     */
    private function getCart()
    {
        $user = Auth::user();
        
        $cart = Cart::firstOrCreate(
            ['user_id' => $user->id, 'is_active' => true],
            ['user_id' => $user->id]
        );
        
        return $cart;
    }
}
