@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col md:flex-row -mx-4">
            <!-- Product Image -->
            <div class="md:flex-1 px-4 mb-6 md:mb-0">
                <div class="rounded-lg overflow-hidden bg-gray-100 mb-4">
                    <img class="w-full h-96 object-cover" src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/product-placeholder.jpg') }}" alt="{{ $product->name }}">
                </div>
                <div class="flex -mx-2 mb-4">
                    <!-- You can add additional product images here if needed -->
                </div>
            </div>
            
            <!-- Product Details -->
            <div class="md:flex-1 px-4">
                <div class="flex items-center mb-2">
                    <a href="{{ route('menu', ['category' => $product->category->slug]) }}" class="text-sm text-primary hover:text-secondary">{{ $product->category->name }}</a>
                    <span class="mx-2 text-gray-400">&bull;</span>
                    <div class="flex items-center">
                        <div class="flex text-yellow-400">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= ($product->avg_rating ?? 5))
                                    <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                @else
                                    <svg class="w-4 h-4 fill-current text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                @endif
                            @endfor
                        </div>
                        <span class="text-sm text-gray-500 ml-2">({{ $product->reviews_count ?? 0 }} ulasan)</span>
                    </div>
                </div>

                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                <p class="text-2xl text-primary font-semibold mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">Deskripsi</h2>
                    <div class="text-gray-600 space-y-3">
                        {{ $product->description }}
                    </div>
                </div>
                
                @if($product->ingredients)
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">Bahan-bahan</h2>
                    <div class="text-gray-600">
                        {{ $product->ingredients }}
                    </div>
                </div>
                @endif

                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-2">Jumlah</h2>
                        <div class="flex items-center">
                            <button type="button" id="decrementQuantity" class="text-gray-500 focus:outline-none focus:text-gray-600 p-2 border border-gray-300 rounded-l-md">
                                <svg class="h-4 w-4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M20 12H4"></path></svg>
                            </button>
                            <input type="number" id="quantity" name="quantity" class="focus:outline-none focus:ring-0 border border-gray-300 h-10 w-16 text-center text-gray-700" value="1" min="1" max="99">
                            <button type="button" id="incrementQuantity" class="text-gray-500 focus:outline-none focus:text-gray-600 p-2 border border-gray-300 rounded-r-md">
                                <svg class="h-4 w-4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 4v16m8-8H4"></path></svg>
                            </button>
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4 mb-6">
                        <button type="submit" class="w-full sm:w-1/2 bg-primary text-white py-3 px-4 rounded-md hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary flex items-center justify-center">
                            <svg class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                            </svg>
                            Tambahkan ke Keranjang
                        </button>
                        <button type="submit" formaction="{{ route('checkout.direct', $product->id) }}" class="w-full sm:w-1/2 bg-secondary text-white py-3 px-4 rounded-md hover:bg-accent focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary">
                            Beli Sekarang
                        </button>
                    </div>
                </form>
                
                <div class="border-t border-gray-200 pt-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center text-gray-600">
                            <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Siap dalam 30 menit</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                            </svg>
                            <span>Pengiriman gratis</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts && $relatedProducts->count() > 0)
        <div class="mt-16">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Mungkin Anda juga suka</h2>
            <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($relatedProducts as $related)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden transition transform hover:scale-105 hover:shadow-lg">
                        <a href="{{ route('menu.show', $related->slug) }}">
                            <img src="{{ $related->image ? asset('storage/' . $related->image) : asset('images/product-placeholder.jpg') }}" 
                                alt="{{ $related->name }}" 
                                class="w-full h-40 object-cover">
                        </a>
                        <div class="p-4">
                            <a href="{{ route('menu.show', $related->slug) }}" class="block">
                                <h3 class="text-lg font-medium text-gray-900">{{ $related->name }}</h3>
                            </a>
                            <p class="mt-1 text-gray-500 text-sm">{{ $related->category->name }}</p>
                            <div class="mt-2 flex items-center justify-between">
                                <span class="text-primary font-semibold">Rp {{ number_format($related->price, 0, ',', '.') }}</span>
                                
                                <form action="{{ route('cart.add', $related->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="inline-flex items-center justify-center p-2 rounded-full text-white bg-primary hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
        
        <!-- Customer Reviews -->
        <div class="mt-16 border-t border-gray-200 pt-8">
            <h2 class="text-2xl font-bold text-gray-900">Ulasan Pelanggan</h2>
            
            @if($product->reviews && $product->reviews->count() > 0)
                <div class="mt-8 space-y-6">
                    @foreach($product->reviews as $review)
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="flex items-center mb-4">
                            <div class="mr-4">
                                <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-semibold">
                                    {{ substr($review->user->name ?? 'Anonim', 0, 1) }}
                                </div>
                            </div>
                            <div>
                                <h4 class="text-lg font-medium text-gray-900">{{ $review->user->name ?? 'Anonim' }}</h4>
                                <div class="flex items-center mt-1">
                                    <div class="flex text-yellow-400">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $review->rating)
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                                </svg>
                                            @else
                                                <svg class="h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-sm text-gray-500 ml-2">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-600">
                            {{ $review->comment }}
                        </p>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="mt-6 bg-gray-50 p-6 rounded-lg text-center">
                    <p class="text-gray-600">Belum ada ulasan. Jadilah yang pertama mengulas produk ini!</p>
                </div>
            @endif
            
            @auth
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900">Berikan ulasan</h3>
                    <form action="{{ route('reviews.store', $product->id) }}" method="POST" class="mt-4">
                        @csrf
                        <div class="mb-4">
                            <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Penilaian</label>
                            <div class="flex items-center">
                                @for ($i = 1; $i <= 5; $i++)
                                    <button type="button" data-rating="{{ $i }}" class="rating-star p-1 text-gray-300 focus:outline-none">
                                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                    </button>
                                @endfor
                                <input type="hidden" name="rating" id="rating" value="5">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Komentar</label>
                            <textarea id="comment" name="comment" rows="4" class="shadow-sm focus:ring-primary focus:border-primary block w-full sm:text-sm border-gray-300 rounded-md" required></textarea>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                Kirim Ulasan
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="mt-8 bg-gray-50 p-6 rounded-lg text-center">
                    <p class="text-gray-600">Silakan <a href="{{ route('login') }}" class="text-primary hover:text-secondary">masuk</a> untuk memberikan ulasan.</p>
                </div>
            @endauth
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Quantity input handling
        const quantityInput = document.getElementById('quantity');
        const decrementBtn = document.getElementById('decrementQuantity');
        const incrementBtn = document.getElementById('incrementQuantity');
        
        decrementBtn.addEventListener('click', function() {
            const currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });
        
        incrementBtn.addEventListener('click', function() {
            const currentValue = parseInt(quantityInput.value);
            if (currentValue < 99) {
                quantityInput.value = currentValue + 1;
            }
        });
        
        // Rating stars handling
        const ratingStars = document.querySelectorAll('.rating-star');
        const ratingInput = document.getElementById('rating');
        
        if (ratingStars.length > 0) {
            ratingStars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = this.dataset.rating;
                    ratingInput.value = rating;
                    
                    // Update star colors
                    ratingStars.forEach(s => {
                        if (s.dataset.rating <= rating) {
                            s.classList.remove('text-gray-300');
                            s.classList.add('text-yellow-400');
                        } else {
                            s.classList.remove('text-yellow-400');
                            s.classList.add('text-gray-300');
                        }
                    });
                });
            });
        }
    });

    // Add this JavaScript to the bottom of your scripts section

    // After successful add to cart
    document.querySelector('form[action*="cart/add"]').addEventListener('submit', function(e) {
        // Update cart count after a brief delay to allow server processing
        setTimeout(() => {
            updateCartCount();
        }, 500);
    });

    function updateCartCount() {
        fetch('/api/cart/count')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('cart-count').textContent = data.data.count;
                    if (document.getElementById('mobile-cart-count')) {
                        document.getElementById('mobile-cart-count').textContent = data.data.count;
                    }
                }
            })
            .catch(error => console.error('Error updating cart count:', error));
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Find the add to cart form and add a listener
        const addToCartForm = document.querySelector('form[action*="cart/add"]');
        if (addToCartForm) {
            addToCartForm.addEventListener('submit', function(e) {
                // Get the form data
                const formData = new FormData(this);
                const quantity = formData.get('quantity');
                
                // Update cart count after a brief delay for form submission
                setTimeout(() => {
                    updateCartCountAfterAdd(quantity);
                }, 300);
            });
        }
    });

    function updateCartCountAfterAdd(quantity) {
        // Get the current count
        const cartCountElem = document.getElementById('cart-count');
        const mobileCartCountElem = document.getElementById('mobile-cart-count');
        
        if (cartCountElem) {
            // Parse the current count and add the new quantity
            const currentCount = parseInt(cartCountElem.textContent) || 0;
            const newCount = currentCount + parseInt(quantity);
            
            // Update the displayed count
            cartCountElem.textContent = newCount;
            if (mobileCartCountElem) {
                mobileCartCountElem.textContent = newCount;
            }
        }
        
        // Also fetch the latest count from server to ensure accuracy
        fetch('/cart/count')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('cart-count').textContent = data.data.count;
                    if (document.getElementById('mobile-cart-count')) {
                        document.getElementById('mobile-cart-count').textContent = data.data.count;
                    }
                }
            })
            .catch(error => console.error('Error updating cart count:', error));
    }
</script>
@endpush