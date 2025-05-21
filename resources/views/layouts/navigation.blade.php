<nav x-data="{ open: false }" class="bg-white shadow-soft sticky top-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Okami Dimsum" class="h-16 w-auto transition-transform duration-300 hover:scale-105">
                </a>

                <!-- Navigation Links -->
                <div class="hidden sm:ml-8 sm:flex sm:space-x-6">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-200 ease-in-out {{ request()->routeIs('home') ? 'border-primary text-primary font-semibold' : 'border-transparent text-dark hover:text-primary hover:border-secondary' }}">
                        Home
                    </a>
                    <a href="{{ route('menu') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-200 ease-in-out {{ request()->routeIs('menu*') ? 'border-primary text-primary font-semibold' : 'border-transparent text-dark hover:text-primary hover:border-secondary' }}">
                        Menu
                    </a>
                    <a href="{{ route('about-us') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-200 ease-in-out {{ request()->routeIs('about-us') ? 'border-primary text-primary font-semibold' : 'border-transparent text-dark hover:text-primary hover:border-secondary' }}">
                        About Us
                    </a>
                    <a href="{{ route('contact') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-200 ease-in-out {{ request()->routeIs('contact') ? 'border-primary text-primary font-semibold' : 'border-transparent text-dark hover:text-primary hover:border-secondary' }}">
                        Contact
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:space-x-4">
                @auth
                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}" class="relative group p-1">
                        <div class="p-2 rounded-full text-dark hover:text-primary transition-colors duration-200">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span id="cart-count" class="absolute -top-1 -right-1 bg-primary text-white text-xs font-semibold rounded-full h-5 w-5 flex items-center justify-center group-hover:bg-secondary transition-colors duration-200">0</span>
                        </div>
                    </a>

                    <!-- User Dropdown -->
                    <div class="ml-3 relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center text-sm font-medium text-dark hover:text-primary focus:outline-none transition duration-200 ease-in-out">
                                    <span class="mr-1">{{ Auth::user()->name }}</span>
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('dashboard')" class="flex items-center">
                                    <svg class="mr-2 h-4 w-4 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    {{ __('Dashboard') }}
                                </x-dropdown-link>
                                
                                <x-dropdown-link :href="route('transactions.index')" class="flex items-center">
                                    <svg class="mr-2 h-4 w-4 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    {{ __('My Orders') }}
                                </x-dropdown-link>
                                
                                <x-dropdown-link :href="route('profile.edit')" class="flex items-center">
                                    <svg class="mr-2 h-4 w-4 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();" class="flex items-center text-red-600 hover:text-red-800">
                                        <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-dark hover:text-primary font-medium transition duration-200 ease-in-out">
                        Log in
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-full text-white bg-primary hover:bg-secondary focus:outline-none transition duration-200 ease-in-out shadow-sm">
                        Register
                    </a>
                @endauth
            </div>

            <!-- Mobile menu button-->
            <div class="flex items-center sm:hidden">
                <button type="button" @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-dark hover:text-primary focus:outline-none" aria-expanded="false">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'inline-flex': open, 'hidden': !open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div :class="{'block': open, 'hidden': !open}" class="sm:hidden animate-fade-in">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium transition duration-200 ease-in-out {{ request()->routeIs('home') ? 'text-primary bg-primary bg-opacity-5' : 'text-dark hover:text-primary hover:bg-gray-50' }}">
                Home
            </a>
            <a href="{{ route('menu') }}" class="block px-3 py-2 rounded-md text-base font-medium transition duration-200 ease-in-out {{ request()->routeIs('menu*') ? 'text-primary bg-primary bg-opacity-5' : 'text-dark hover:text-primary hover:bg-gray-50' }}">
                Menu
            </a>
            <a href="{{ route('about-us') }}" class="block px-3 py-2 rounded-md text-base font-medium transition duration-200 ease-in-out {{ request()->routeIs('about-us') ? 'text-primary bg-primary bg-opacity-5' : 'text-dark hover:text-primary hover:bg-gray-50' }}">
                About Us
            </a>
            <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-md text-base font-medium transition duration-200 ease-in-out {{ request()->routeIs('contact') ? 'text-primary bg-primary bg-opacity-5' : 'text-dark hover:text-primary hover:bg-gray-50' }}">
                Contact
            </a>
        </div>

        @auth
            <div class="pt-4 pb-3 border-t border-gray-200">
                <div class="flex items-center px-4">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-primary text-white flex items-center justify-center">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-dark">{{ Auth::user()->name }}</div>
                        <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                    <a href="{{ route('cart.index') }}" class="ml-auto relative flex-shrink-0 bg-white p-1 rounded-full">
                        <svg class="h-6 w-6 text-dark hover:text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span id="mobile-cart-count" class="absolute -top-1 -right-1 bg-primary text-white text-xs font-semibold rounded-full h-5 w-5 flex items-center justify-center">0</span>
                    </a>
                </div>
                <div class="mt-3 space-y-1 px-2">
                    <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-dark hover:text-primary hover:bg-gray-50 transition duration-200 ease-in-out">
                        Dashboard
                    </a>
                    <a href="{{ route('transactions.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-dark hover:text-primary hover:bg-gray-50 transition duration-200 ease-in-out">
                        My Orders
                    </a>
                    <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md text-base font-medium text-dark hover:text-primary hover:bg-gray-50 transition duration-200 ease-in-out">
                        Profile
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}"
                                class="block px-3 py-2 rounded-md text-base font-medium text-red-600 hover:text-red-800 hover:bg-gray-50 transition duration-200 ease-in-out"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            Log Out
                        </a>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-3 border-t border-gray-200">
                <div class="grid grid-cols-2 gap-4 px-4">
                    <a href="{{ route('login') }}" class="text-center py-2 px-4 rounded-full border border-primary text-primary hover:bg-primary hover:text-white transition duration-200 ease-in-out">
                        Log In
                    </a>
                    <a href="{{ route('register') }}" class="text-center py-2 px-4 rounded-full bg-primary text-white hover:bg-secondary transition duration-200 ease-in-out">
                        Register
                    </a>
                </div>
            </div>
        @endauth
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Update cart count
        @auth
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
            .catch(error => console.error('Error fetching cart count:', error));
        @endauth

        // Add scroll behavior for navbar
        const nav = document.querySelector('nav');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                nav.classList.add('shadow-md');
            } else {
                nav.classList.remove('shadow-md');
            }
        });
    });
</script>
