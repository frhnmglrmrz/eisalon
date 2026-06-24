@extends('layouts.app')

@section('title', 'Daftar Member - Alan\'s Art Hair Salon')

@section('content')
<div class="min-h-screen flex items-center justify-center px-6 py-12">
    <div class="max-w-md w-full">
        <!-- Header -->
        <div class="text-center mb-8 animate-fadeIn">
            <div class="w-20 h-20 bg-gradient-to-br from-indigo-900 to-indigo-700 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                <i class="fas fa-user-plus text-white text-3xl"></i>
            </div>
            <h1 class="text-4xl font-bold gradient-text mb-2">Daftar Member</h1>
            <p class="text-gray-600">Buat akun untuk mendapatkan pelayanan terbaik</p>
        </div>

        <!-- Register Form -->
        <div class="glass-effect rounded-2xl shadow-2xl p-8 animate-fadeIn">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-6">
                    <label for="name" class="block text-gray-700 font-bold mb-3 text-sm">
                        <i class="fas fa-user mr-2 text-indigo-600"></i>Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}"
                        required 
                        autofocus
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:outline-none transition text-sm @error('name') border-red-500 @enderror"
                        placeholder="Nama lengkap Anda"
                    >
                    @error('name')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-gray-700 font-bold mb-3 text-sm">
                        <i class="fas fa-envelope mr-2 text-indigo-600"></i>Alamat Email <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        required
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:outline-none transition text-sm @error('email') border-red-500 @enderror"
                        placeholder="nama@email.com"
                    >
                    @error('email')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="mb-6">
                    <label for="phone" class="block text-gray-700 font-bold mb-3 text-sm">
                        <i class="fas fa-phone mr-2 text-indigo-600"></i>No. WhatsApp <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="tel" 
                        id="phone" 
                        name="phone" 
                        value="{{ old('phone') }}"
                        required
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:outline-none transition text-sm @error('phone') border-red-500 @enderror"
                        placeholder="Contoh: 08123456789"
                    >
                    @error('phone')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 font-bold mb-3 text-sm">
                        <i class="fas fa-lock mr-2 text-indigo-600"></i>Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:outline-none transition text-sm @error('password') border-red-500 @enderror"
                            placeholder="Minimal 8 karakter"
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword('password', 'toggleIcon1')"
                            class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-indigo-600 transition"
                        >
                            <i class="fas fa-eye" id="toggleIcon1"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-gray-700 font-bold mb-3 text-sm">
                        <i class="fas fa-lock mr-2 text-indigo-600"></i>Konfirmasi Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            required
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:outline-none transition text-sm"
                            placeholder="Ulangi password Anda"
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword('password_confirmation', 'toggleIcon2')"
                            class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-indigo-600 transition"
                        >
                            <i class="fas fa-eye" id="toggleIcon2"></i>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    class="w-full btn-primary text-white px-8 py-4 rounded-full font-bold text-lg shadow-lg mb-6 transition"
                >
                    <i class="fas fa-user-plus mr-2"></i>Buat Akun Member
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

                <!-- Login Link -->
                <div class="text-center text-sm">
                    <p class="text-gray-600">
                        Sudah punya akun member? 
                        <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 transition font-bold">
                            Masuk di sini
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Benefits -->
        <div class="mt-8 glass-effect rounded-2xl p-6 shadow-md border border-gray-150">
            <h3 class="font-bold text-gray-800 mb-3 text-center text-base">Keuntungan Menjadi Member</h3>
            <div class="space-y-3 text-sm">
                <div class="flex items-start text-gray-700">
                    <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                    <span>Kemudahan melacak status riwayat booking</span>
                </div>
                <div class="flex items-start text-gray-700">
                    <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                    <span>Proses booking cepat tanpa input ulang data kontak</span>
                </div>
                <div class="flex items-start text-gray-700">
                    <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                    <span>Dapatkan prioritas pelayanan dan update promo salon terbaru</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function togglePassword(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const toggleIcon = document.getElementById(iconId);
        
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
