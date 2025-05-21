@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Keranjang Belanja</h1>
    
    <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Ringkasan Pesanan</h2>
                <div class="space-y-4 mb-6">
                    @foreach ($cartItems as $item)
                    <div class="flex justify-between items-center border-b pb-3">
                        <div class="flex items-center">
                            <div class="bg-cover bg-center w-16 h-16 rounded" 
                                style="background-image: url('{{ $item->product->image_url }}')"></div>
                            <div class="ml-4">
                                <p class="font-medium text-gray-800">{{ $item->product->name }}</p>
                                <p class="text-sm text-gray-600">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <p class="font-medium text-gray-800">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                    </div>
                    @endforeach
                </div>
                <div class="border-t pt-4 mb-6">
                    <div class="flex justify-between items-center">
                        <p class="text-lg font-semibold text-gray-800">Total</p>
                        <p class="text-xl font-bold text-primary">Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            
            <div>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Informasi Pengiriman</h2>
                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="shipping_name" class="block text-sm font-medium text-gray-700">Nama</label>
                            <input type="text" name="shipping_name" id="shipping_name" value="{{ $user->name }}" 
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary">
                            @error('shipping_name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="shipping_phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                            <input type="text" name="shipping_phone" id="shipping_phone" value="{{ old('shipping_phone') }}" 
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary">
                            @error('shipping_phone')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="shipping_address" class="block text-sm font-medium text-gray-700">Alamat</label>
                            <textarea name="shipping_address" id="shipping_address" rows="3" 
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary">{{ old('shipping_address') }}</textarea>
                            @error('shipping_address')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700">Catatan Pesanan (opsional)</label>
                            <textarea name="notes" id="notes" rows="2" 
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <button type="submit" class="w-full bg-primary hover:bg-secondary text-white font-semibold py-3 px-4 rounded-md shadow transition duration-200">
                            Lanjutkan ke Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection