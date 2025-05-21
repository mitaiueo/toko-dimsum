<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the user's transactions.
     */
    public function index(Request $request)
    {
        $query = Transaction::where('user_id', Auth::id());
        
        // Filter by payment status if provided
        if ($request->has('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }
        
        // Filter by shipping status if provided
        if ($request->has('shipping_status')) {
            $query->where('shipping_status', $request->shipping_status);
        }
        
        // Sort transactions
        $sortField = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        
        $allowedSorts = ['created_at', 'total_amount', 'order_number'];
        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortDirection);
        } else {
            $query->orderBy('created_at', 'desc');
        }
        
        $transactions = $query->paginate($request->get('per_page', 10));
        
        return response()->json([
            'success' => true,
            'data' => $transactions,
        ]);
    }
    
    /**
     * Display the specified transaction.
     */
    public function show($id)
    {
        $transaction = Transaction::with('items.product')->findOrFail($id);
        
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
