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
<body class="min-h-screen bg-gray-50 font-sans text-gray-900 antialiased" x-data="{ sidebarOpen: false }">
    @auth
        <!-- Authenticated Layout (Sidebar) -->
        <div class="flex h-screen overflow-hidden bg-gray-100">
            <!-- Sidebar -->
            <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-white/80 backdrop-blur-xl border-r border-gray-200 transition-transform duration-300 ease-in-out transform lg:translate-x-0 lg:static lg:inset-0 shadow-lg"
                   :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
                
                <!-- Sidebar Header -->
                <div class="h-16 flex items-center justify-center border-b border-gray-100/50">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-pink-500 to-orange-500 rounded-full flex items-center justify-center shadow-md">
                            <i class="fas fa-spa text-white text-sm"></i>
                        </div>
                        <span class="text-xl font-bold gradient-text">Ei Salon</span>
                    </a>
                </div>

                <!-- Sidebar Content -->
                <div class="overflow-y-auto h-[calc(100vh-4rem)] py-4 px-3 space-y-1">
                    
                    @if(auth()->user()->isAdmin())
                        <!-- ADMIN MENU -->
                        <div class="px-3 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Administration</div>
                        
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-pink-50 hover:text-pink-600 rounded-xl transition-all group {{ request()->routeIs('admin.dashboard') ? 'bg-pink-50 text-pink-600 shadow-sm' : '' }}">
                            <i class="fas fa-tachometer-alt w-5 h-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-pink-600' : 'text-gray-400 group-hover:text-pink-500' }}"></i>
                            <span class="font-medium">Dashboard</span>
                        </a>

                        <a href="{{ route('admin.services.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-pink-50 hover:text-pink-600 rounded-xl transition-all group {{ request()->routeIs('admin.services.*') ? 'bg-pink-50 text-pink-600 shadow-sm' : '' }}">
                            <i class="fas fa-spa w-5 h-5 mr-3 {{ request()->routeIs('admin.services.*') ? 'text-pink-600' : 'text-gray-400 group-hover:text-pink-500' }}"></i>
                            <span class="font-medium">Services</span>
                        </a>

                        <a href="{{ route('admin.therapists.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-pink-50 hover:text-pink-600 rounded-xl transition-all group {{ request()->routeIs('admin.therapists.*') ? 'bg-pink-50 text-pink-600 shadow-sm' : '' }}">
                            <i class="fas fa-user-md w-5 h-5 mr-3 {{ request()->routeIs('admin.therapists.*') ? 'text-pink-600' : 'text-gray-400 group-hover:text-pink-500' }}"></i>
                            <span class="font-medium">Therapists</span>
                        </a>

                        <a href="{{ route('admin.bookings.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-pink-50 hover:text-pink-600 rounded-xl transition-all group {{ request()->routeIs('admin.bookings.*') ? 'bg-pink-50 text-pink-600 shadow-sm' : '' }}">
                            <i class="fas fa-calendar-check w-5 h-5 mr-3 {{ request()->routeIs('admin.bookings.*') ? 'text-pink-600' : 'text-gray-400 group-hover:text-pink-500' }}"></i>
                            <span class="font-medium">Bookings</span>
                        </a>

                        <a href="{{ route('admin.payments.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-pink-50 hover:text-pink-600 rounded-xl transition-all group {{ request()->routeIs('admin.payments.*') ? 'bg-pink-50 text-pink-600 shadow-sm' : '' }}">
                            <i class="fas fa-money-bill-wave w-5 h-5 mr-3 {{ request()->routeIs('admin.payments.*') ? 'text-pink-600' : 'text-gray-400 group-hover:text-pink-500' }}"></i>
                            <span class="font-medium">Payments</span>
                        </a>

                        <a href="{{ route('admin.reviews.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-pink-50 hover:text-pink-600 rounded-xl transition-all group {{ request()->routeIs('admin.reviews.*') ? 'bg-pink-50 text-pink-600 shadow-sm' : '' }}">
                            <i class="fas fa-star w-5 h-5 mr-3 {{ request()->routeIs('admin.reviews.*') ? 'text-pink-600' : 'text-gray-400 group-hover:text-pink-500' }}"></i>
                            <span class="font-medium">Reviews</span>
                        </a>
                        
                        <a href="{{ route('admin.notifications.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-pink-50 hover:text-pink-600 rounded-xl transition-all group {{ request()->routeIs('admin.notifications.*') ? 'bg-pink-50 text-pink-600 shadow-sm' : '' }}">
                            <i class="fas fa-bell w-5 h-5 mr-3 {{ request()->routeIs('admin.notifications.*') ? 'text-pink-600' : 'text-gray-400 group-hover:text-pink-500' }}"></i>
                            <span class="font-medium">Notifications</span>
                        </a>

                    @else
                        <!-- CUSTOMER MENU -->
                        <div class="px-3 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Menu</div>

                         <a href="{{ route('home') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-pink-50 hover:text-pink-600 rounded-xl transition-all group {{ request()->routeIs('home') ? 'bg-pink-50 text-pink-600 shadow-sm' : '' }}">
                            <i class="fas fa-home w-5 h-5 mr-3 {{ request()->routeIs('home') ? 'text-pink-600' : 'text-gray-400 group-hover:text-pink-500' }}"></i>
                            <span class="font-medium">Home</span>
                        </a>

                        <a href="{{ route('services.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-pink-50 hover:text-pink-600 rounded-xl transition-all group {{ request()->routeIs('services.*') ? 'bg-pink-50 text-pink-600 shadow-sm' : '' }}">
                            <i class="fas fa-spa w-5 h-5 mr-3 {{ request()->routeIs('services.*') ? 'text-pink-600' : 'text-gray-400 group-hover:text-pink-500' }}"></i>
                            <span class="font-medium">Home Service</span>
                        </a>

                        <a href="{{ route('catalog.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-pink-50 hover:text-pink-600 rounded-xl transition-all group {{ request()->routeIs('catalog.*') ? 'bg-pink-50 text-pink-600 shadow-sm' : '' }}">
                            <i class="fas fa-book-open w-5 h-5 mr-3 {{ request()->routeIs('catalog.*') ? 'text-pink-600' : 'text-gray-400 group-hover:text-pink-500' }}"></i>
                            <span class="font-medium">E-Catalog</span>
                        </a>

                        <a href="{{ route('bookings.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-pink-50 hover:text-pink-600 rounded-xl transition-all group {{ request()->routeIs('bookings.*') ? 'bg-pink-50 text-pink-600 shadow-sm' : '' }}">
                            <i class="fas fa-calendar-alt w-5 h-5 mr-3 {{ request()->routeIs('bookings.*') ? 'text-pink-600' : 'text-gray-400 group-hover:text-pink-500' }}"></i>
                            <span class="font-medium">My Bookings</span>
                        </a>
                    @endif
                    
                    <div class="border-t border-dashed border-gray-200 my-2 mx-4"></div>

                    <!-- PROFILE & LOGOUT -->
                     <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-4 py-3 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-xl transition-all group">
                            <i class="fas fa-sign-out-alt w-5 h-5 mr-3 text-gray-400 group-hover:text-red-500"></i>
                            <span class="font-medium">Logout</span>
                        </button>
                    </form>

                </div>
            </aside>

            <!-- Main Content Wrapper -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Mobile Header -->
                <header class="flex items-center justify-between p-4 bg-white shadow-sm lg:hidden z-40">
                    <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                    <span class="font-bold text-lg gradient-text">Ei Salon</span>
                    <div class="w-8"></div> <!-- Spacer for center alignment logic if needed -->
                </header>

                <!-- Scrollable Main Content -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-4 lg:p-8">
                     @if(session('success'))
                        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl animate-fadeIn shadow-sm flex items-center" role="alert">
                            <i class="fas fa-check-circle mr-3 text-xl"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-4 rounded-xl animate-fadeIn shadow-sm" role="alert">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-exclamation-triangle mr-3 text-xl"></i>
                                <span class="font-bold">There were some problems with your input:</span>
                            </div>
                            <ul class="list-disc list-inside ml-8 text-sm">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')
                </main>
            </div>

            <!-- Overlay for Mobile Sidebar -->
            <div x-show="sidebarOpen" @click="sidebarOpen = false" 
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden text-white" style="display: none;">
            </div>
        </div>

    @else
        <!-- Guest Layout (Existing Navbar) -->
        
        <!-- Navigation -->
        <nav class="glass-effect fixed w-full top-0 z-50 shadow-lg" x-data="{ mobileMenuOpen: false }">
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
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-pink-600 transition font-medium">Home</a>
                        <a href="{{ route('services.index') }}" class="text-gray-700 hover:text-pink-600 transition font-medium">Services</a>
                        <a href="{{ route('catalog.index') }}" class="text-gray-700 hover:text-pink-600 transition font-medium">
                            <i class="fas fa-book mr-1"></i>E-Catalog
                        </a>
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-pink-600 transition font-medium">Login</a>
                        <a href="{{ route('register') }}" class="btn-primary text-white px-6 py-2 rounded-full font-medium">Register</a>
                    </div>
                    
                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-gray-700 focus:outline-none">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
                
                <!-- Mobile Menu -->
                <div x-show="mobileMenuOpen" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform -translate-y-2"
                     class="md:hidden mt-4 pb-4 border-t border-gray-100 pt-4 space-y-3" style="display: none;">
                     
                    <a href="{{ route('home') }}" class="block py-2 text-gray-700 hover:text-pink-600 transition">Home</a>
                    <a href="{{ route('services.index') }}" class="block py-2 text-gray-700 hover:text-pink-600 transition">Services</a>
                    <a href="{{ route('catalog.index') }}" class="block py-2 text-gray-700 hover:text-pink-600 transition">
                        <i class="fas fa-book mr-2"></i>E-Catalog
                    </a>
                    <div class="border-t border-gray-100 my-2"></div>
                    <a href="{{ route('login') }}" class="block py-2 text-gray-700 hover:text-pink-600 transition">Login</a>
                    <a href="{{ route('register') }}" class="block w-full text-center py-2 btn-primary text-white rounded-lg transition shadow-md">Register</a>
                </div>
            </div>
        </nav>
        
        <!-- Main Content (Guest) -->
        <div class="pt-24 min-h-screen flex flex-col">
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
            
            <div class="flex-grow">
                @yield('content')
            </div>

            <!-- Footer (Guest Only) -->
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
                                <li><a href="{{ route('home') }}" class="text-gray-600 hover:text-pink-600 transition">Home</a></li>
                                <li><a href="{{ route('services.index') }}" class="text-gray-600 hover:text-pink-600 transition">Services</a></li>
                                <li><a href="{{ route('catalog.index') }}" class="text-gray-600 hover:text-pink-600 transition">E-Catalog</a></li>
                                <li><a href="{{ route('home') }}#about" class="text-gray-600 hover:text-pink-600 transition">About Us</a></li>
                                <li><a href="{{ route('home') }}#contact" class="text-gray-600 hover:text-pink-600 transition">Contact</a></li>
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
        </div>
    @endauth

    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', function() {
                const menu = document.getElementById('mobile-menu');
                menu.classList.toggle('hidden');
            });
        }
        
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
