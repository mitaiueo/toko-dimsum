<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the user's transactions.
     */
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('transactions.index', compact('transactions'));
    }
    
    /**
     * Display the specified transaction.
     */
    public function show(Transaction $transaction)
    {
        // Ensure the transaction belongs to the current user
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }
        
        $transaction->load('items.product');
        
        return view('transactions.show', compact('transaction'));
    }
}
