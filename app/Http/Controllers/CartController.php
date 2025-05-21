<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display the user's cart.
     */
    public function index()
    {
        $cart = $this->getCart();
        $cartItems = $cart->items()->with(['product', 'product.category'])->get();
        
        // Calculate order summary
        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        
        $tax = $subtotal * 0.1; // 10% tax
        $total = $subtotal + $tax;
        
        // Attach calculated values to the cart object
        $cart->subtotal = $subtotal;
        $cart->tax = $tax;
        $cart->total = $total;
        
        return view('cart.index', compact('cartItems', 'cart'));
    }
    
    /**
     * Add a product to the cart.
     */
    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        
        $cart = $this->getCart();
        
        // Check if the product is already in the cart
        $existingItem = $cart->items()->where('product_id', $product->id)->first();
        
        if ($existingItem) {
            // Update quantity if product already exists in cart
            $existingItem->update([
                'quantity' => $existingItem->quantity + $request->quantity,
            ]);
        } else {
            // Add new item to cart
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price,
            ]);
        }
        
        return redirect()->route('cart.index')->with('success', 'Product added to cart successfully!');
    }
    
    /**
     * Update the quantity of a cart item.
     */
    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        
        // Ensure the cart item belongs to the current user
        if ($cartItem->cart->user_id !== Auth::id()) {
            abort(403);
        }
        
        $cartItem->update([
            'quantity' => $request->quantity,
        ]);
        
        return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
    }
    
    /**
     * Remove a cart item.
     */
    public function remove(CartItem $cartItem)
    {
        // Ensure the cart item belongs to the current user
        if ($cartItem->cart->user_id !== Auth::id()) {
            abort(403);
        }
        
        $cartItem->delete();
        
        return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
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
    
    /**
     * Get the current cart item count for the user.
     */
    public function getCartCount()
    {
        $cart = $this->getCart();
        $count = $cart->items()->sum('quantity');
        
        return response()->json([
            'success' => true,
            'data' => [
                'count' => $count
            ]
        ]);
    }
}
