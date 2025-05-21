@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">Keranjang Belanja Anda</h1>
            <a href="{{ route('menu') }}" class="text-primary hover:text-secondary flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Lanjutkan Belanja
            </a>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
            <button type="button" class="absolute top-0 right-0 px-4 py-3 close-alert">
                <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
            <button type="button" class="absolute top-0 right-0 px-4 py-3 close-alert">
                <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Cart Items -->
        <div class="lg:w-2/3">
            @if($cartItems->isEmpty())
                <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                    <div class="flex flex-col items-center justify-center">
                        <svg class="h-16 w-16 text-gray-400 mb-4" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Keranjang Anda kosong</h3>
                        <p class="text-gray-500 mb-6">Sepertinya Anda belum menambahkan produk apapun ke keranjang.</p>
                        <a href="{{ route('menu') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            Lihat Menu
                        </a>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-lg shadow-sm divide-y divide-gray-200">
                    @foreach($cartItems as $cartItem)
                        <div class="p-6" id="cart-item-{{ $cartItem->id }}">
                            <div class="flex flex-col sm:flex-row sm:items-center">
                                <div class="flex-shrink-0 sm:mr-4 mb-4 sm:mb-0">
                                    <img class="h-24 w-24 rounded-md object-cover" src="{{ $cartItem->product->image ? asset('storage/' . $cartItem->product->image) : asset('images/product-placeholder.jpg') }}" alt="{{ $cartItem->product->name }}">
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-lg font-medium text-gray-900">
                                        <a href="{{ route('menu.show', $cartItem->product->slug) }}" class="hover:text-primary">
                                            {{ $cartItem->product->name }}
                                        </a>
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">{{ $cartItem->product->category->name }}</p>
                                    <p class="mt-1 text-sm text-primary font-medium">Rp {{ number_format($cartItem->product->price, 0, ',', '.') }}</p>
                                </div>
                                <div class="mt-4 sm:mt-0 sm:ml-6">
                                    <div class="flex items-center justify-end">
                                        <form method="POST" action="{{ route('cart.update', $cartItem->id) }}" class="flex items-center">
                                            @csrf
                                            @method('PATCH')
                                            <button type="button" class="decrement-quantity text-gray-500 focus:outline-none focus:text-gray-600 p-1">
                                                <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path d="M20 12H4"></path>
                                                </svg>
                                            </button>
                                            <input type="number" name="quantity" class="quantity-input mx-2 border border-gray-300 rounded-md w-14 py-1 px-2 text-center focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary" value="{{ $cartItem->quantity }}" min="1" max="99">
                                            <button type="button" class="increment-quantity text-gray-500 focus:outline-none focus:text-gray-600 p-1">
                                                <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path d="M12 4v16m8-8H4"></path>
                                                </svg>
                                            </button>
                                            <button type="submit" class="ml-2 text-sm text-primary hover:text-secondary">
                                                Perbarui
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('cart.remove', $cartItem->id) }}" class="ml-4">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                    <p class="mt-2 text-right text-sm font-semibold">
                                        Subtotal: Rp <span class="item-subtotal">{{ number_format($cartItem->product->price * $cartItem->quantity, 0, ',', '.') }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-4 flex justify-between">
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 flex items-center">
                            <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Kosongkan Keranjang
                        </button>
                    </form>
                </div>
            @endif
        </div>
        
        <!-- Order Summary -->
        <div class="lg:w-1/3">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Ringkasan Pesanan</h3>
                <div class="flow-root">
                    <dl class="divide-y divide-gray-200">
                        <div class="py-4 flex items-center justify-between">
                            <dt class="text-base text-gray-600">Subtotal</dt>
                            <dd class="text-base font-medium text-gray-900">Rp {{ number_format($cart->subtotal ?? 0, 0, ',', '.') }}</dd>
                        </div>
                    </dl>
                </div>
                
                @if(!$cartItems->isEmpty())
                    <div class="mt-6">
                        <a href="{{ route('checkout.index') }}" class="w-full bg-primary border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary flex items-center justify-center">
                            Lanjutkan ke Pembayaran
                        </a>
                    </div>
                @endif
                
                <div class="mt-6 border-t border-gray-200 pt-4">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Metode Pembayaran yang Diterima</h4>
                    <div class="flex space-x-2">
                        <div class="flex-1 rounded-md bg-gray-100 p-2 flex items-center justify-center">
                            <span class="text-xs text-gray-800 font-medium">Transfer Bank</span>
                        </div>
                        <div class="flex-1 rounded-md bg-gray-100 p-2 flex items-center justify-center">
                            <span class="text-xs text-gray-800 font-medium">E-Wallet</span>
                        </div>
                        <div class="flex-1 rounded-md bg-gray-100 p-2 flex items-center justify-center">
                            <span class="text-xs text-gray-800 font-medium">Kartu Kredit</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-sm mt-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Butuh Bantuan?</h3>
                <div class="space-y-3">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3 text-sm text-gray-600">
                            <p>Pesanan biasanya siap dalam 30 menit</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        <div class="ml-3 text-sm text-gray-600">
                            <p>Proses pembayaran yang aman</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z" />
                            </svg>
                        </div>
                        <div class="ml-3 text-sm text-gray-600">
                            <p>Pengiriman gratis untuk pesanan di atas Rp 100.000</p>
                        </div>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="#" class="text-sm font-medium text-primary hover:text-secondary">
                        Hubungi Layanan Pelanggan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Close alert messages
        const closeAlerts = document.querySelectorAll('.close-alert');
        closeAlerts.forEach(button => {
            button.addEventListener('click', function() {
                this.parentElement.classList.add('hidden');
            });
        });
        
        // Quantity increment/decrement
        const decrementButtons = document.querySelectorAll('.decrement-quantity');
        const incrementButtons = document.querySelectorAll('.increment-quantity');
        const quantityInputs = document.querySelectorAll('.quantity-input');
        
        decrementButtons.forEach((button, index) => {
            button.addEventListener('click', function() {
                if (quantityInputs[index].value > 1) {
                    quantityInputs[index].value = parseInt(quantityInputs[index].value) - 1;
                    updateItemSubtotal(index);
                }
            });
        });
        
        incrementButtons.forEach((button, index) => {
            button.addEventListener('click', function() {
                if (quantityInputs[index].value < 99) {
                    quantityInputs[index].value = parseInt(quantityInputs[index].value) + 1;
                    updateItemSubtotal(index);
                }
            });
        });
        
        // Update subtotal calculation when quantity changes
        function updateItemSubtotal(index) {
            const cartItemId = quantityInputs[index].closest('[id^="cart-item-"]').id.split('-')[2];
            const quantity = parseInt(quantityInputs[index].value);
            const priceElement = document.querySelector(`#cart-item-${cartItemId} .text-primary.font-medium`);
            
            if (priceElement) {
                const price = parseInt(priceElement.textContent.replace('Rp ', '').replace('.', ''));
                const subtotal = price * quantity;
                const subtotalElement = document.querySelector(`#cart-item-${cartItemId} .item-subtotal`);
                
                if (subtotalElement) {
                    subtotalElement.textContent = new Intl.NumberFormat('id-ID').format(subtotal);
                }
            }
        }
    });
</script>
@endpush