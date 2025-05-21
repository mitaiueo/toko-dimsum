<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-light py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <!-- Logo & Header -->
            <div class="text-center mb-10">
                <a href="{{ route('home') }}" class="inline-block">
                    <img class="h-16 mx-auto mb-3 transition-transform duration-300 hover:scale-105" src="{{ asset('images/logoo.png') }}" alt="Okami Dimsum">
                </a>
                <h2 class="text-3xl font-bold text-dark">Welcome back</h2>
                <p class="mt-2 text-gray-600">Sign in to your account</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <div class="bg-white rounded-xl shadow-soft overflow-hidden transform transition-all hover:shadow-hover">
                <form method="POST" action="{{ route('login') }}" class="px-6 py-8">
                    @csrf
                    

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-dark font-medium" />
                        <x-text-input id="email" 
                            class="block mt-2 w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-primary focus:border-primary transition-colors" 
                            type="email" 
                            name="email" 
                            :value="old('email')" 
                            required 
                            autofocus 
                            autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm" />
                    </div>

                    <!-- Password -->
                    <div class="mt-6">
                        <div class="flex items-center justify-between">
                            <x-input-label for="password" :value="__('Password')" class="text-dark font-medium" />
                            @if (Route::has('password.request'))
                                <a class="text-sm text-primary hover:text-secondary transition-colors" href="{{ route('password.request') }}">
                                    {{ __('Forgot password?') }}
                                </a>
                            @endif
                        </div>
                        <x-text-input id="password" 
                            class="block mt-2 w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-primary focus:border-primary transition-colors"
                            type="password"
                            name="password"
                            required 
                            autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm" />
                    </div>

                    <!-- Remember Me -->
                    <div class="mt-6 flex items-center">
                        <input id="remember_me" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary" name="remember">
                        <label for="remember_me" class="ms-3 text-sm text-gray-600">{{ __('Remember me') }}</label>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-6">
                        <button type="submit" class="w-full py-3 px-4 rounded-lg bg-primary text-white font-medium hover:bg-secondary transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary shadow-md">
                            {{ __('Sign in') }}
                        </button>
                    </div>
                </form>
            </div>

            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="font-medium text-primary hover:text-secondary transition-colors">
                        Create an account
                    </a>
                </p>
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('home') }}" class="text-sm text-gray-600 hover:text-primary transition-colors inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to home
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
