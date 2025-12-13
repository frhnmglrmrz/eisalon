@extends('layouts.app')

@section('title', 'Register - Ei Salon')

@section('content')
<div class="min-h-screen flex items-center justify-center px-6 py-12">
    <div class="max-w-md w-full">
        <!-- Header -->
        <div class="text-center mb-8 animate-fadeIn">
            <div class="w-20 h-20 bg-gradient-to-br from-pink-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4 animate-float">
                <i class="fas fa-user-plus text-white text-3xl"></i>
            </div>
            <h1 class="text-4xl font-bold gradient-text mb-2">Join Us</h1>
            <p class="text-gray-600">Create your account and start your beauty journey</p>
        </div>

        <!-- Register Form -->
        <div class="glass-effect rounded-2xl shadow-2xl p-8 animate-slideInRight">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-6">
                    <label for="name" class="block text-gray-700 font-bold mb-3">
                        <i class="fas fa-user mr-2"></i>Full Name
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}"
                        required 
                        autofocus
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none transition @error('name') border-red-500 @enderror"
                        placeholder="Your full name"
                    >
                    @error('name')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

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
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none transition @error('email') border-red-500 @enderror"
                        placeholder="your@email.com"
                    >
                    @error('email')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone (Optional) -->
                <div class="mb-6">
                    <label for="phone" class="block text-gray-700 font-bold mb-3">
                        <i class="fas fa-phone mr-2"></i>Phone Number <span class="text-gray-400 font-normal">(Optional)</span>
                    </label>
                    <input 
                        type="tel" 
                        id="phone" 
                        name="phone" 
                        value="{{ old('phone') }}"
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none transition @error('phone') border-red-500 @enderror"
                        placeholder="+62 xxx xxxx xxxx"
                    >
                    @error('phone')
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
                            placeholder="Minimum 8 characters"
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword('password', 'toggleIcon1')"
                            class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-pink-500 transition"
                        >
                            <i class="fas fa-eye" id="toggleIcon1"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-gray-700 font-bold mb-3">
                        <i class="fas fa-lock mr-2"></i>Confirm Password
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            required
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none transition"
                            placeholder="Re-enter your password"
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword('password_confirmation', 'toggleIcon2')"
                            class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-pink-500 transition"
                        >
                            <i class="fas fa-eye" id="toggleIcon2"></i>
                        </button>
                    </div>
                </div>

                <!-- Terms & Conditions -->
                <div class="mb-6">
                    <label class="flex items-start cursor-pointer">
                        <input 
                            type="checkbox" 
                            required
                            class="w-4 h-4 mt-1 text-pink-500 border-gray-300 rounded focus:ring-pink-500"
                        >
                        <span class="ml-2 text-sm text-gray-700">
                            I agree to the <a href="#" class="text-pink-500 hover:text-pink-600 transition font-medium">Terms & Conditions</a> and <a href="#" class="text-pink-500 hover:text-pink-600 transition font-medium">Privacy Policy</a>
                        </span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    class="w-full btn-primary text-white px-8 py-4 rounded-full font-bold text-lg shadow-lg mb-6"
                >
                    <i class="fas fa-user-plus mr-2"></i>Create Account
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

                <!-- Login Link -->
                <div class="text-center">
                    <p class="text-gray-600">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="text-pink-500 hover:text-pink-600 transition font-bold">
                            Login here
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Benefits -->
        <div class="mt-8 glass-effect rounded-xl p-4">
            <h3 class="font-bold text-gray-800 mb-3 text-center">Why Join Ei Salon?</h3>
            <div class="space-y-2 text-sm">
                <div class="flex items-center text-gray-700">
                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                    <span>Exclusive member discounts up to 20%</span>
                </div>
                <div class="flex items-center text-gray-700">
                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                    <span>Priority booking access</span>
                </div>
                <div class="flex items-center text-gray-700">
                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                    <span>Birthday special treats</span>
                </div>
                <div class="flex items-center text-gray-700">
                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                    <span>Personalized beauty recommendations</span>
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

    // Password strength indicator (optional enhancement)
    const passwordInput = document.getElementById('password');
    passwordInput.addEventListener('input', function() {
        const strength = checkPasswordStrength(this.value);
        // You can add visual feedback here
    });

    function checkPasswordStrength(password) {
        let strength = 0;
        if (password.length >= 8) strength++;
        if (password.match(/[a-z]+/)) strength++;
        if (password.match(/[A-Z]+/)) strength++;
        if (password.match(/[0-9]+/)) strength++;
        if (password.match(/[$@#&!]+/)) strength++;
        return strength;
    }
</script>
@endpush
@endsection
