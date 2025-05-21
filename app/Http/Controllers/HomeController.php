<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        // Get featured products for the banner section
        $featuredProducts = Product::where('is_featured', true)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Get popular products (those with most sales)
        $popularProducts = Product::where('is_active', true)
            ->withCount(['transactionItems as sales_count' => function ($query) {
                $query->join('transactions', 'transactions.id', '=', 'transaction_items.transaction_id')
                      ->where('transactions.payment_status', 'paid');
            }])
            ->orderByDesc('sales_count')
            ->take(8)
            ->get();
            
        // Update this line to load product counts
        $categories = Category::withCount('products')->get();
            
        return view('home.index', compact('featuredProducts', 'popularProducts', 'categories'));
    }
}
