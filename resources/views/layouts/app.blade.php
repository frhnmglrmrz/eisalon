<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Ei Salon - Beauty & Wellness')</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #ffeef8 0%, #fff5f0 100%);
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
        }
        
        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }
        
        /* Custom animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-40px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(40px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }
        
        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }
            100% {
                background-position: 1000px 0;
            }
        }
        
        .animate-fadeIn {
            animation: fadeIn 0.8s ease-out forwards;
        }
        
        .animate-slideInLeft {
            animation: slideInLeft 0.8s ease-out forwards;
        }
        
        .animate-slideInRight {
            animation: slideInRight 0.8s ease-out forwards;
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #ec4899 0%, #f97316 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #ec4899 0%, #f97316 100%);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(236, 72, 153, 0.4);
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        /* Loading shimmer effect */
        .shimmer {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 1000px 100%;
            animation: shimmer 2s infinite;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #ec4899 0%, #f97316 100%);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #db2777 0%, #ea580c 100%);
        }
    </style>
    
    @stack('styles')
</head>
<body class="min-h-screen">
    <!-- Navigation -->
    <nav class="glass-effect fixed w-full top-0 z-50 shadow-lg">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-pink-500 to-orange-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-spa text-white text-xl"></i>
                    </div>
                    <span class="text-2xl font-bold gradient-text">Ei Salon</span>
                </a>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-pink-600 transition font-medium">Services</a>
                    
                    @auth
                        <!-- Notification Bell -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="text-gray-700 hover:text-pink-600 transition relative">
                                <i class="fas fa-bell text-xl"></i>
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center animate-pulse">
                                        {{ auth()->user()->unreadNotifications->count() }}
                                    </span>
                                @endif
                            </button>

                            <!-- Dropdown -->
                            <div x-show="open" 
                                 @click.away="open = false"
                                 class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-2xl overflow-hidden z-50 border border-gray-100"
                                 style="display: none;">
                                <div class="p-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                                    <h3 class="font-bold text-gray-800">Notifications</h3>
                                    @if(auth()->user()->unreadNotifications->count() > 0)
                                        <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-xs text-pink-500 hover:text-pink-700 font-medium">
                                                Mark all read
                                            </button>
                                        </form>
                                    @endif
                                </div>
                                <div class="max-h-96 overflow-y-auto">
                                    @forelse(auth()->user()->notifications as $notification)
                                        <div class="p-4 border-b border-gray-100 hover:bg-pink-50 transition {{ $notification->read_at ? 'opacity-75' : 'bg-white' }}">
                                            <a href="{{ route('notifications.mark-read', $notification->id) }}" class="flex items-start">
                                                <div class="flex-shrink-0 mr-3">
                                                    @if($notification->data['type'] == 'payment_received')
                                                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-500">
                                                            <i class="fas fa-money-bill-wave"></i>
                                                        </div>
                                                    @else
                                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-500">
                                                            <i class="fas fa-check-circle"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-800 {{ $notification->read_at ? '' : 'font-bold' }}">
                                                        {{ $notification->data['message'] }}
                                                    </p>
                                                    <p class="text-xs text-gray-500 mt-1">
                                                        {{ $notification->created_at->diffForHumans() }}
                                                    </p>
                                                </div>
                                            </a>
                                        </div>
                                    @empty
                                        <div class="p-8 text-center text-gray-500">
                                            <i class="far fa-bell-slash text-3xl mb-2"></i>
                                            <p>No notifications yet</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        @if(auth()->user()->isAdmin())
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="text-gray-700 hover:text-pink-600 transition font-medium flex items-center">
                                    <i class="fas fa-cog mr-2"></i>Admin
                                    <i class="fas fa-chevron-down ml-1 text-xs"></i>
                                </button>
                                <div x-show="open" 
                                     @click.away="open = false"
                                     class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-2xl overflow-hidden z-50 border border-gray-100"
                                     style="display: none;">
                                    <div class="py-2">
                                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-pink-50 transition">
                                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                                        </a>
                                        <a href="{{ route('admin.services.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-pink-50 transition">
                                            <i class="fas fa-spa mr-2"></i>Services
                                        </a>
                                        <a href="{{ route('admin.therapists.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-pink-50 transition">
                                            <i class="fas fa-user-md mr-2"></i>Therapists
                                        </a>
                                        <a href="{{ route('admin.bookings.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-pink-50 transition">
                                            <i class="fas fa-calendar-check mr-2"></i>Bookings
                                        </a>
                                        <a href="{{ route('admin.payments.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-pink-50 transition">
                                            <i class="fas fa-money-bill-wave mr-2"></i>Payments
                                        </a>
                                        <a href="{{ route('admin.reviews.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-pink-50 transition">
                                            <i class="fas fa-star mr-2"></i>Reviews
                                        </a>
                                        <a href="{{ route('admin.notifications.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-pink-50 transition">
                                            <i class="fas fa-bell mr-2"></i>Notifications
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('bookings.index') }}" class="text-gray-700 hover:text-pink-600 transition font-medium">My Bookings</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-pink-600 transition font-medium">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-pink-600 transition font-medium">Login</a>
                        <a href="{{ route('register') }}" class="btn-primary text-white px-6 py-2 rounded-full font-medium">Register</a>
                    @endauth
                </div>
                
                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="md:hidden text-gray-700">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
            
            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden mt-4 pb-4">
                <a href="{{ route('home') }}" class="block py-2 text-gray-700 hover:text-pink-600 transition">Services</a>
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="block py-2 text-gray-700 hover:text-pink-600 transition">Admin Dashboard</a>
                        <a href="{{ route('admin.services.index') }}" class="block py-2 text-gray-700 hover:text-pink-600 transition">Services</a>
                        <a href="{{ route('admin.therapists.index') }}" class="block py-2 text-gray-700 hover:text-pink-600 transition">Therapists</a>
                        <a href="{{ route('admin.bookings.index') }}" class="block py-2 text-gray-700 hover:text-pink-600 transition">Bookings</a>
                        <a href="{{ route('admin.payments.index') }}" class="block py-2 text-gray-700 hover:text-pink-600 transition">Payments</a>
                        <a href="{{ route('admin.reviews.index') }}" class="block py-2 text-gray-700 hover:text-pink-600 transition">Reviews</a>
                        <a href="{{ route('admin.notifications.index') }}" class="block py-2 text-gray-700 hover:text-pink-600 transition">Notifications</a>
                    @else
                        <a href="{{ route('bookings.index') }}" class="block py-2 text-gray-700 hover:text-pink-600 transition">My Bookings</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="block py-2 text-gray-700 hover:text-pink-600 transition w-full text-left">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block py-2 text-gray-700 hover:text-pink-600 transition">Login</a>
                    <a href="{{ route('register') }}" class="block py-2 text-gray-700 hover:text-pink-600 transition">Register</a>
                @endauth
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <div class="pt-20">
        @if(session('success'))
            <div class="container mx-auto px-6 mt-4">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg animate-fadeIn" role="alert">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif
        
        @if($errors->any())
            <div class="container mx-auto px-6 mt-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg animate-fadeIn" role="alert">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        
        @yield('content')
    </div>
    
    <!-- Footer -->
    <footer class="glass-effect mt-20 border-t border-gray-200">
        <div class="container mx-auto px-6 py-12">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-pink-500 to-orange-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-spa text-white text-xl"></i>
                        </div>
                        <span class="text-2xl font-bold gradient-text">Ei Salon</span>
                    </div>
                    <p class="text-gray-600">Your premium beauty and wellness destination</p>
                </div>
                
                <div>
                    <h4 class="font-bold text-gray-800 mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-600 hover:text-pink-600 transition">Services</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-pink-600 transition">About Us</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-pink-600 transition">Contact</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-bold text-gray-800 mb-4">Contact</h4>
                    <ul class="space-y-2 text-gray-600">
                        <li><i class="fas fa-phone mr-2"></i> +62 xxx xxxx xxxx</li>
                        <li><i class="fas fa-envelope mr-2"></i> info@eisalon.com</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i> Jakarta, Indonesia</li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-bold text-gray-800 mb-4">Follow Us</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gradient-to-br from-pink-500 to-orange-500 rounded-full flex items-center justify-center text-white hover:shadow-lg transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gradient-to-br from-pink-500 to-orange-500 rounded-full flex items-center justify-center text-white hover:shadow-lg transition">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gradient-to-br from-pink-500 to-orange-500 rounded-full flex items-center justify-center text-white hover:shadow-lg transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-200 mt-8 pt-8 text-center text-gray-600">
                <p>&copy; 2024 Ei Salon. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
        
        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('[role="alert"]');
            alerts.forEach(alert => {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.5s';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
    
    @stack('scripts')
</body>
</html>
