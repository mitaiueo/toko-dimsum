@extends('layouts.app')

@section('title', 'Menu')

@section('content')
    <!-- Hero Banner -->
    <div class="relative bg-cover bg-center h-64 md:h-80" style="background-image: url('{{ asset('images/bannerhd.jpg') }}')">
        <div class="absolute inset-0 bg-dark bg-opacity-60"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col justify-center">
            <h1 class="text-4xl font-bold text-white mb-2">Menu Kami</h1>
            <p class="text-lg text-light">Dimsum autentik buatan tangan dengan bahan premium</p>
            <div class="mt-6 flex flex-wrap gap-4">
                <a href="#steamed" class="inline-flex items-center px-4 py-2 bg-primary hover:bg-secondary text-white rounded-full transition-colors duration-300 text-sm">
                    Dimsum Kukus
                </a>
                <a href="#fried" class="inline-flex items-center px-4 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 text-white rounded-full transition-colors duration-300 text-sm">
                    Dimsum Goreng
                </a>
                <a href="#specials" class="inline-flex items-center px-4 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 text-white rounded-full transition-colors duration-300 text-sm">
                    Menu Spesial Chef
                </a>
            </div>
        </div>
    </div>

    <div class="bg-light py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row">
                <!-- Sidebar Filters -->
                <div class="w-full md:w-64 flex-shrink-0 mb-8 md:mb-0 md:mr-8">
                    <div class="bg-white rounded-xl shadow-soft p-6 sticky top-24">
                        <h3 class="font-medium text-lg text-dark mb-4">Kategori</h3>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input id="all-categories" name="category" type="radio" value="" 
                                    {{ !request('category') ? 'checked' : '' }}
                                    class="focus:ring-primary h-4 w-4 text-primary border-gray-300">
                                <label for="all-categories" class="ml-3 block text-sm font-medium text-dark">
                                    Semua Kategori
                                </label>
                            </div>

                            @foreach($categories as $category)
                            <div class="flex items-center">
                                <input id="category-{{ $category->id }}" name="category" type="radio" value="{{ $category->slug }}" 
                                    {{ request('category') == $category->slug ? 'checked' : '' }}
                                    class="focus:ring-primary h-4 w-4 text-primary border-gray-300">
                                <label for="category-{{ $category->id }}" class="ml-3 block text-sm font-medium text-dark">
                                    {{ $category->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>

                        <div class="border-t border-gray-200 pt-4 mt-6">
                            <h3 class="font-medium text-lg text-dark mb-4">Rentang Harga</h3>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <input id="price-all" name="price" type="radio" value="" 
                                        {{ !request('price_range') ? 'checked' : '' }}
                                        class="focus:ring-primary h-4 w-4 text-primary border-gray-300">
                                    <label for="price-all" class="ml-3 block text-sm font-medium text-dark">
                                        Semua Harga
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="price-1" name="price" type="radio" value="0-25000" 
                                        {{ request('price_range') == '0-25000' ? 'checked' : '' }}
                                        class="focus:ring-primary h-4 w-4 text-primary border-gray-300">
                                    <label for="price-1" class="ml-3 block text-sm font-medium text-dark">
                                        Di bawah Rp 25.000
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="price-2" name="price" type="radio" value="25000-50000" 
                                        {{ request('price_range') == '25000-50000' ? 'checked' : '' }}
                                        class="focus:ring-primary h-4 w-4 text-primary border-gray-300">
                                    <label for="price-2" class="ml-3 block text-sm font-medium text-dark">
                                        Rp 25.000 - Rp 50.000
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="price-3" name="price" type="radio" value="50000-100000" 
                                        {{ request('price_range') == '50000-100000' ? 'checked' : '' }}
                                        class="focus:ring-primary h-4 w-4 text-primary border-gray-300">
                                    <label for="price-3" class="ml-3 block text-sm font-medium text-dark">
                                        Rp 50.000 - Rp 100.000
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="price-4" name="price" type="radio" value="100000-0" 
                                        {{ request('price_range') == '100000-0' ? 'checked' : '' }}
                                        class="focus:ring-primary h-4 w-4 text-primary border-gray-300">
                                    <label for="price-4" class="ml-3 block text-sm font-medium text-dark">
                                        Di atas Rp 100.000
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="button" id="filterButton" class="w-full bg-primary text-white py-3 px-4 rounded-lg hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors duration-300 font-medium shadow-md">
                                Terapkan Filter
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="flex-1">
                    <!-- Search and Sort -->
                    <div class="bg-white rounded-xl shadow-soft p-4 mb-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <!-- Search Bar -->
                            <div class="flex-1">
                                <div class="relative rounded-lg shadow-sm">
                                    <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                                        class="focus:ring-primary focus:border-primary block w-full rounded-lg border-gray-300 pl-4 pr-10 py-2" 
                                        placeholder="Cari menu...">
                                    <button type="button" id="searchButton" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <svg class="h-5 w-5 text-gray-400 hover:text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Sort Options -->
                            <div class="flex items-center">
                                <span class="text-gray-600 mr-2 whitespace-nowrap">Urut berdasarkan:</span>
                                <select id="sortProducts" class="rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 text-sm">
                                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama (A-Z)</option>
                                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama (Z-A)</option>
                                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga (Rendah ke Tinggi)</option>
                                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga (Tinggi ke Rendah)</option>
                                    <option value="newest" {{ request('sort') == 'newest' || !request('sort') ? 'selected' : '' }}>Terbaru</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    @if($products->isEmpty())
                        <div class="bg-white p-8 rounded-xl shadow-soft text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-dark">Menu tidak ditemukan</h3>
                            <p class="mt-2 text-gray-500">
                                Coba sesuaikan pencarian atau kriteria filter Anda.
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('menu') }}" class="inline-flex items-center px-5 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-primary hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors duration-300">
                                    Reset Filter
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach($products as $product)
                                <div class="bg-white rounded-xl shadow-soft overflow-hidden group hover:shadow-hover transition-all duration-300 transform hover:-translate-y-1">
                                    <a href="{{ route('menu.show', $product->slug) }}" class="block relative aspect-w-16 aspect-h-10">
                                        <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/product-placeholder.jpg') }}" 
                                            alt="{{ $product->name }}" 
                                            class="w-full h-48 object-cover transition-transform duration-700 group-hover:scale-105">
                                        @if($product->is_featured)
                                        <div class="absolute top-3 left-3">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary text-white">
                                                Unggulan
                                            </span>
                                        </div>
                                        @endif
                                    </a>
                                    <div class="p-5">
                                        <div class="flex justify-between items-start">
                                            <a href="{{ route('menu.show', $product->slug) }}" class="block">
                                                <h3 class="text-lg font-semibold text-dark group-hover:text-primary transition-colors duration-300">{{ $product->name }}</h3>
                                            </a>
                                            <span class="text-primary font-bold text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        </div>
                                        <p class="mt-2 text-gray-500 text-sm flex items-center">
                                            <span class="inline-block w-2 h-2 rounded-full bg-primary mr-2"></span>
                                            {{ $product->category->name }}
                                        </p>
                                        @if($product->description)
                                        <p class="mt-3 text-gray-600 line-clamp-2 text-sm">
                                            {{ $product->description }}
                                        </p>
                                        @endif
                                        <div class="mt-4 flex items-center justify-between">
                                            <a href="{{ route('menu.show', $product->slug) }}" class="text-sm text-primary hover:text-secondary font-medium flex items-center">
                                                Lihat Detail
                                                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </a>
                                            
                                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="inline-flex items-center justify-center p-2 rounded-full text-white bg-primary hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary shadow-md transition-colors duration-300">
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

                        <div class="mt-8">
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter and sort functionality
        const filterButton = document.getElementById('filterButton');
        const searchButton = document.getElementById('searchButton');
        const sortSelect = document.getElementById('sortProducts');

        function applyFilters() {
            const categoryValue = document.querySelector('input[name="category"]:checked')?.value || '';
            const priceValue = document.querySelector('input[name="price"]:checked')?.value || '';
            const searchValue = document.getElementById('searchInput').value;
            const sortValue = sortSelect.value;

            let url = '{{ route("menu") }}';
            const params = new URLSearchParams();

            if (categoryValue) params.append('category', categoryValue);
            if (priceValue) params.append('price_range', priceValue);
            if (searchValue) params.append('search', searchValue);
            if (sortValue) params.append('sort', sortValue);

            if (params.toString()) {
                url += '?' + params.toString();
            }

            window.location.href = url;
        }

        // Event listeners
        filterButton.addEventListener('click', applyFilters);
        searchButton.addEventListener('click', applyFilters);
        sortSelect.addEventListener('change', applyFilters);
        
        // Allow search with Enter key
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                applyFilters();
            }
        });
    });
</script>
@endpush