<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', "Alan's Art Hair Salon")</title>
    
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
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
        }
        
        html {
            scroll-behavior: smooth;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out forwards;
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #1e1b4b 0%, #4338ca 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #1e1b4b 0%, #4338ca 100%);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(30, 27, 75, 0.3);
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #4338ca;
            border-radius: 4px;
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen bg-gray-50 text-gray-900 antialiased" x-data="{ sidebarOpen: false }">
    @auth
        <!-- Authenticated Layout (Sidebar) -->
        <div class="flex h-screen overflow-hidden bg-gray-100">
            <!-- Sidebar -->
            <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transition-transform duration-300 ease-in-out transform lg:translate-x-0 lg:static lg:inset-0 shadow-sm"
                   :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
                
                <!-- Sidebar Header -->
                <div class="h-16 flex items-center justify-center border-b border-gray-100">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-indigo-900 to-indigo-700 rounded-full flex items-center justify-center shadow-md">
                            <i class="fas fa-scissors text-white text-xs"></i>
                        </div>
                        <span class="text-lg font-bold text-indigo-900">Alan's Art Salon</span>
                    </a>
                </div>

                <!-- Sidebar Content -->
                <div class="overflow-y-auto h-[calc(100vh-4rem)] py-4 px-3 space-y-1">
                    
                    @if(auth()->user()->isAdmin())
                        <!-- ADMIN MENU -->
                        <div class="px-3 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Menu Admin</div>
                        
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-900 rounded-xl transition-all group {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-900 shadow-sm' : '' }}">
                            <i class="fas fa-tachometer-alt w-5 h-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-indigo-900' : 'text-gray-400 group-hover:text-indigo-800' }}"></i>
                            <span class="font-medium">Dashboard</span>
                        </a>

                        <a href="{{ route('admin.layanan.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-900 rounded-xl transition-all group {{ request()->routeIs('admin.layanan.*') ? 'bg-indigo-50 text-indigo-900 shadow-sm' : '' }}">
                            <i class="fas fa-cut w-5 h-5 mr-3 {{ request()->routeIs('admin.layanan.*') ? 'text-indigo-900' : 'text-gray-400 group-hover:text-indigo-800' }}"></i>
                            <span class="font-medium">Layanan</span>
                        </a>

                        <a href="{{ route('admin.slot.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-900 rounded-xl transition-all group {{ request()->routeIs('admin.slot.*') ? 'bg-indigo-50 text-indigo-900 shadow-sm' : '' }}">
                            <i class="fas fa-calendar-alt w-5 h-5 mr-3 {{ request()->routeIs('admin.slot.*') ? 'text-indigo-900' : 'text-gray-400 group-hover:text-indigo-800' }}"></i>
                            <span class="font-medium">Slot Jadwal</span>
                        </a>

                        <a href="{{ route('admin.bookings.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-900 rounded-xl transition-all group {{ request()->routeIs('admin.bookings.*') ? 'bg-indigo-50 text-indigo-900 shadow-sm' : '' }}">
                            <i class="fas fa-calendar-check w-5 h-5 mr-3 {{ request()->routeIs('admin.bookings.*') ? 'text-indigo-900' : 'text-gray-400 group-hover:text-indigo-800' }}"></i>
                            <span class="font-medium">Reservasi</span>
                        </a>

                        <a href="{{ route('admin.galeri.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-900 rounded-xl transition-all group {{ request()->routeIs('admin.galeri.*') ? 'bg-indigo-50 text-indigo-900 shadow-sm' : '' }}">
                            <i class="fas fa-images w-5 h-5 mr-3 {{ request()->routeIs('admin.galeri.*') ? 'text-indigo-900' : 'text-gray-400 group-hover:text-indigo-800' }}"></i>
                            <span class="font-medium">Galeri</span>
                        </a>

                    @else
                        <!-- CUSTOMER MENU -->
                        <div class="px-3 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Pelanggan</div>

                        <a href="{{ route('customer.bookings.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-900 rounded-xl transition-all group {{ request()->routeIs('customer.bookings.index') ? 'bg-indigo-50 text-indigo-900 shadow-sm' : '' }}">
                            <i class="fas fa-tachometer-alt w-5 h-5 mr-3 {{ request()->routeIs('customer.bookings.index') ? 'text-indigo-900' : 'text-gray-400 group-hover:text-indigo-800' }}"></i>
                            <span class="font-medium">Dashboard</span>
                        </a>

                        <a href="{{ route('catalog.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-900 rounded-xl transition-all group {{ request()->routeIs('catalog.index') ? 'bg-indigo-50 text-indigo-900 shadow-sm' : '' }}">
                            <i class="fas fa-cut w-5 h-5 mr-3 {{ request()->routeIs('catalog.index') ? 'text-indigo-900' : 'text-gray-400 group-hover:text-indigo-800' }}"></i>
                            <span class="font-medium">Layanan</span>
                        </a>

                        <a href="{{ route('gallery.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-900 rounded-xl transition-all group {{ request()->routeIs('gallery.index') ? 'bg-indigo-50 text-indigo-900 shadow-sm' : '' }}">
                            <i class="fas fa-images w-5 h-5 mr-3 {{ request()->routeIs('gallery.index') ? 'text-indigo-900' : 'text-gray-400 group-hover:text-indigo-800' }}"></i>
                            <span class="font-medium">Galeri</span>
                        </a>

                        <a href="{{ route('booking.create') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-900 rounded-xl transition-all group {{ request()->routeIs('booking.create') ? 'bg-indigo-50 text-indigo-900 shadow-sm' : '' }}">
                            <i class="fas fa-calendar-plus w-5 h-5 mr-3 {{ request()->routeIs('booking.create') ? 'text-indigo-900' : 'text-gray-400 group-hover:text-indigo-800' }}"></i>
                            <span class="font-medium">Buat Reservasi</span>
                        </a>
                    @endif
                    
                    <div class="border-t border-gray-200 my-2 mx-4"></div>

                    <!-- PROFILE & LOGOUT -->
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl transition-all group">
                            <i class="fas fa-sign-out-alt w-5 h-5 mr-3 text-red-400 group-hover:text-red-600"></i>
                            <span class="font-medium">Keluar (Logout)</span>
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
                    <span class="font-bold text-lg text-indigo-900">Alan's Art Salon</span>
                    <div class="w-8"></div>
                </header>

                <!-- Scrollable Main Content -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-4 lg:p-8">
                    @if(session('success'))
                        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl animate-fadeIn shadow-sm flex items-center" role="alert">
                            <i class="fas fa-check-circle mr-3 text-xl text-green-600"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl animate-fadeIn shadow-sm flex items-center" role="alert">
                            <i class="fas fa-exclamation-circle mr-3 text-xl text-red-600"></i>
                            <div>{{ session('error') }}</div>
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
        <nav class="glass-effect fixed w-full top-0 z-50 shadow-sm" x-data="{ mobileMenuOpen: false }">
            <div class="container mx-auto px-6 py-4">
                <div class="flex items-center justify-between">
                    <!-- Logo -->
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-900 to-indigo-700 rounded-full flex items-center justify-center">
                            <i class="fas fa-scissors text-white text-xl"></i>
                        </div>
                        <span class="text-xl font-bold text-indigo-900">Alan's Art Hair Salon</span>
                    </a>
                    
                    <!-- Desktop Menu -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-indigo-900 transition font-medium">Beranda</a>
                        <a href="{{ route('catalog.index') }}" class="text-gray-700 hover:text-indigo-900 transition font-medium">Layanan</a>
                        <a href="{{ route('gallery.index') }}" class="text-gray-700 hover:text-indigo-900 transition font-medium">Galeri</a>
                        <a href="{{ route('booking.create') }}" class="text-gray-700 hover:text-indigo-900 transition font-medium">Reservasi</a>
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-900 transition font-medium">Login</a>
                        <a href="{{ route('register') }}" class="btn-primary text-white px-6 py-2 rounded-full font-medium">Daftar</a>
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
                     
                    <a href="{{ route('home') }}" class="block py-2 text-gray-700 hover:text-indigo-900 transition">Beranda</a>
                    <a href="{{ route('catalog.index') }}" class="block py-2 text-gray-700 hover:text-indigo-900 transition">Layanan</a>
                    <a href="{{ route('gallery.index') }}" class="block py-2 text-gray-700 hover:text-indigo-900 transition">Galeri</a>
                    <a href="{{ route('booking.create') }}" class="block py-2 text-gray-700 hover:text-indigo-900 transition">Reservasi</a>
                    <div class="border-t border-gray-100 my-2"></div>
                    <a href="{{ route('login') }}" class="block py-2 text-gray-700 hover:text-indigo-900 transition">Login</a>
                    <a href="{{ route('register') }}" class="block w-full text-center py-2 btn-primary text-white rounded-lg transition shadow-md">Daftar</a>
                </div>
            </div>
        </nav>
        
        <!-- Main Content (Guest) -->
        <div class="pt-24 min-h-screen flex flex-col">
            @if(session('success'))
                <div class="container mx-auto px-6 mt-4">
                    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg animate-fadeIn shadow-sm" role="alert">
                        <i class="fas fa-check-circle mr-2 text-green-600"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            
            @if(session('error'))
                <div class="container mx-auto px-6 mt-4">
                    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg animate-fadeIn shadow-sm" role="alert">
                        <i class="fas fa-exclamation-circle mr-2 text-red-600"></i>
                        {{ session('error') }}
                    </div>
                </div>
            @endif
            
            @if($errors->any())
                <div class="container mx-auto px-6 mt-4">
                    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg animate-fadeIn shadow-sm" role="alert">
                        <i class="fas fa-exclamation-triangle mr-2 text-red-600"></i>
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

            <!-- Footer -->
            <footer class="bg-indigo-950 text-indigo-200 mt-20 border-t border-indigo-900">
                <div class="container mx-auto px-6 py-12">
                    <div class="grid md:grid-cols-4 gap-8">
                        <div>
                            <div class="flex items-center space-x-2 mb-4">
                                <div class="w-10 h-10 bg-gradient-to-br from-indigo-800 to-indigo-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-scissors text-white text-xl"></i>
                                </div>
                                <span class="text-xl font-bold text-white">Alan's Art Salon</span>
                            </div>
                            <p class="text-indigo-300">Pilihan terbaik untuk perawatan rambut premium dan gaya masa kini.</p>
                        </div>
                        
                        <div>
                            <h4 class="font-bold text-white mb-4">Navigasi</h4>
                            <ul class="space-y-2">
                                <li><a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a></li>
                                <li><a href="{{ route('catalog.index') }}" class="hover:text-white transition">Layanan</a></li>
                                <li><a href="{{ route('gallery.index') }}" class="hover:text-white transition">Galeri</a></li>
                                <li><a href="{{ route('booking.create') }}" class="hover:text-white transition">Reservasi</a></li>
                            </ul>
                        </div>
                        
                        <div>
                            <h4 class="font-bold text-white mb-4">Kontak</h4>
                            <ul class="space-y-2 text-indigo-300">
                                <li><i class="fas fa-phone mr-2 text-indigo-400"></i> +62 895 2380 8660</li>
                                <li><i class="fas fa-map-marker-alt mr-2 text-indigo-400"></i> Batam, Indonesia</li>
                            </ul>
                        </div>
                        
                        <div>
                            <h4 class="font-bold text-white mb-4">Jam Operasional</h4>
                            <ul class="space-y-2 text-indigo-300">
                                <li>Senin - Minggu: 09:00 - 17:00</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="border-t border-indigo-900 mt-8 pt-8 text-center text-indigo-400 text-sm">
                        <p>&copy; 2026 Alan's Art Hair Salon. All rights reserved.</p>
                    </div>
                </div>
            </footer>
        </div>
    @endauth

    <script>
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
