<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/menu/{product:slug}', [MenuController::class, 'show'])->name('menu.show');
Route::view('/about-us', 'about-us')->name('about-us');
Route::view('/contact', 'contact')->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');


// Authentication Routes (already required from auth.php)

// Protected Routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');
    
    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{transaction}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/payment/{transaction}', [CheckoutController::class, 'payment'])->name('checkout.payment');
    Route::post('/checkout/direct/{product}', [CheckoutController::class, 'directCheckout'])->name('checkout.direct');
    Route::post('/checkout/update-status', [CheckoutController::class, 'updateStatus'])->name('checkout.update-status');
    
    // Transactions
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    
    // Payment callback
    Route::post('/payment/notification', [CheckoutController::class, 'notification'])->withoutMiddleware(['csrf']);
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Reviews
    Route::post('/reviews/{product}', [ReviewController::class, 'store'])->name('reviews.store');
});

require __DIR__.'/auth.php';
