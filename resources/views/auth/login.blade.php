@extends('layouts.app')

@section('title', 'Masuk (Login) - Alan\'s Art Hair Salon')

@section('content')
<div class="min-h-screen flex items-center justify-center px-6 py-12">
    <div class="max-w-md w-full">
        <!-- Header -->
        <div class="text-center mb-8 animate-fadeIn">
            <div class="w-20 h-20 bg-gradient-to-br from-indigo-900 to-indigo-700 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                <i class="fas fa-scissors text-white text-3xl"></i>
            </div>
            <h1 class="text-4xl font-bold gradient-text mb-2">Selamat Datang</h1>
            <p class="text-gray-600">Masuk untuk mengelola reservasi salon Anda</p>
        </div>

        <!-- Login Form -->
        <div class="glass-effect rounded-2xl shadow-2xl p-8 animate-fadeIn">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-gray-700 font-bold mb-3 text-sm">
                        <i class="fas fa-envelope mr-2 text-indigo-600"></i>Alamat Email
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        required 
                        autofocus
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:outline-none transition text-sm @error('email') border-red-500 @enderror"
                        placeholder="nama@email.com"
                    >
                    @error('email')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 font-bold mb-3 text-sm">
                        <i class="fas fa-lock mr-2 text-indigo-600"></i>Password
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:outline-none transition text-sm @error('password') border-red-500 @enderror"
                            placeholder="Masukkan password Anda"
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword()"
                            class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-indigo-600 transition"
                        >
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mb-6 text-sm">
                    <label class="flex items-center cursor-pointer">
                        <input 
                            type="checkbox" 
                            name="remember" 
                            class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                        >
                        <span class="ml-2 text-gray-700 font-medium">Ingat Saya</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    class="w-full btn-primary text-white px-8 py-4 rounded-full font-bold text-lg shadow-lg mb-6 transition"
                >
                    <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                </button>

                <!-- Divider -->
                <div class="relative mb-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="px-4 bg-white text-gray-500">ATAU</span>
                    </div>
                </div>

                <!-- Register Link -->
                <div class="text-center text-sm">
                    <p class="text-gray-600">
                        Belum punya akun member? 
                        <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-800 transition font-bold">
                            Daftar di sini
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Features -->
        <div class="mt-8 grid grid-cols-3 gap-4 text-center">
            <div>
                <div class="text-indigo-600 text-xl mb-1">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="text-xs text-gray-500">Reservasi Mudah</div>
            </div>
            <div>
                <div class="text-indigo-600 text-xl mb-1">
                    <i class="fas fa-user-friends"></i>
                </div>
                <div class="text-xs text-gray-500">Stylist Ahli</div>
            </div>
            <div>
                <div class="text-indigo-600 text-xl mb-1">
                    <i class="fas fa-cut"></i>
                </div>
                <div class="text-xs text-gray-500">Layanan Premium</div>
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
