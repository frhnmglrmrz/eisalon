@extends('layouts.app')

@section('title', 'Login - Ei Salon')

@section('content')
<div class="min-h-screen flex items-center justify-center px-6 py-12">
    <div class="max-w-md w-full">
        <!-- Header -->
        <div class="text-center mb-8 animate-fadeIn">
            <div class="w-20 h-20 bg-gradient-to-br from-pink-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4 animate-float">
                <i class="fas fa-spa text-white text-3xl"></i>
            </div>
            <h1 class="text-4xl font-bold gradient-text mb-2">Welcome Back</h1>
            <p class="text-gray-600">Login to continue your beauty journey</p>
        </div>

        <!-- Login Form -->
        <div class="glass-effect rounded-2xl shadow-2xl p-8 animate-slideInLeft">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-gray-700 font-bold mb-3">
                        <i class="fas fa-envelope mr-2"></i>Email Address
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        required 
                        autofocus
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none transition @error('email') border-red-500 @enderror"
                        placeholder="your@email.com"
                    >
                    @error('email')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 font-bold mb-3">
                        <i class="fas fa-lock mr-2"></i>Password
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none transition @error('password') border-red-500 @enderror"
                            placeholder="Enter your password"
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword()"
                            class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-pink-500 transition"
                        >
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center cursor-pointer">
                        <input 
                            type="checkbox" 
                            name="remember" 
                            class="w-4 h-4 text-pink-500 border-gray-300 rounded focus:ring-pink-500"
                        >
                        <span class="ml-2 text-gray-700">Remember me</span>
                    </label>
                    <a href="#" class="text-pink-500 hover:text-pink-600 transition text-sm font-medium">
                        Forgot password?
                    </a>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    class="w-full btn-primary text-white px-8 py-4 rounded-full font-bold text-lg shadow-lg mb-6"
                >
                    <i class="fas fa-sign-in-alt mr-2"></i>Login
                </button>

                <!-- Divider -->
                <div class="relative mb-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500">Or</span>
                    </div>
                </div>

                <!-- Register Link -->
                <div class="text-center">
                    <p class="text-gray-600">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="text-pink-500 hover:text-pink-600 transition font-bold">
                            Register here
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Features -->
        <div class="mt-8 grid grid-cols-3 gap-4 text-center">
            <div class="animate-fadeIn" style="animation-delay: 0.2s;">
                <div class="text-pink-500 text-2xl mb-2">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="text-xs text-gray-600">Easy Booking</div>
            </div>
            <div class="animate-fadeIn" style="animation-delay: 0.3s;">
                <div class="text-pink-500 text-2xl mb-2">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="text-xs text-gray-600">Secure Payment</div>
            </div>
            <div class="animate-fadeIn" style="animation-delay: 0.4s;">
                <div class="text-pink-500 text-2xl mb-2">
                    <i class="fas fa-star"></i>
                </div>
                <div class="text-xs text-gray-600">Quality Service</div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }
</script>
@endpush
@endsection
