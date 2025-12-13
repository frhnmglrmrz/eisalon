@extends('layouts.app')

@section('title', 'E-Catalog - Ei Salon')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden bg-gradient-to-br from-pink-50 via-white to-orange-50 py-16">
    <div class="container mx-auto px-6">
        <div class="text-center animate-fadeIn">
            <h1 class="text-5xl md:text-6xl font-bold gradient-text mb-4">
                E-Catalog Layanan
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                Jelajahi berbagai layanan kecantikan dan perawatan kami. Pilih layanan yang sesuai dengan kebutuhan Anda.
            </p>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="container mx-auto px-6 py-8">
    <div class="glass-effect rounded-2xl p-6 shadow-lg mb-8">
        <form method="GET" action="{{ route('catalog.index') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Cari layanan..." 
                    value="{{ request('search') }}"
                    class="w-full pl-12 pr-4 py-3 rounded-xl bg-white border-2 border-gray-200 focus:border-pink-500 focus:outline-none"
                >
            </div>
            <select 
                name="category" 
                class="px-6 py-3 rounded-xl bg-white border-2 border-gray-200 focus:border-pink-500 focus:outline-none"
                onchange="this.form.submit()"
            >
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $category)) }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn-primary text-white px-8 py-3 rounded-xl font-medium">
                <i class="fas fa-search mr-2"></i>Cari
            </button>
        </form>
    </div>

    <!-- Services by Category -->
    @if(request('category') == '' && request('search') == '')
        @foreach($servicesByCategory as $category => $categoryServices)
            <div class="mb-12 animate-fadeIn">
                <div class="flex items-center mb-6">
                    <div class="w-1 h-12 bg-gradient-to-b from-pink-500 to-orange-500 rounded-full mr-4"></div>
                    <h2 class="text-3xl font-bold gradient-text">
                        {{ ucfirst(str_replace('_', ' ', $category)) }}
                    </h2>
                    <span class="ml-4 px-4 py-1 bg-pink-100 text-pink-700 rounded-full text-sm font-medium">
                        {{ $categoryServices->count() }} Layanan
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($categoryServices as $service)
                        <div class="glass-effect rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                            <!-- Service Image -->
                            <div class="relative h-48 bg-gradient-to-br from-pink-400 to-orange-400">
                                @if($service->image)
                                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas fa-spa text-white text-5xl opacity-50"></i>
                                    </div>
                                @endif
                                <div class="absolute top-4 right-4">
                                    <span class="px-3 py-1 bg-white bg-opacity-90 text-pink-600 rounded-full text-xs font-bold">
                                        Rp {{ number_format($service->price, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Service Info -->
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $service->name }}</h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ Str::limit($service->description, 100) }}</p>
                                
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i class="far fa-clock mr-2"></i>
                                        <span>{{ $service->duration }} menit</span>
                                    </div>
                                    @if($service->total_reviews > 0)
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star text-xs {{ $i <= round($service->average_rating) ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                            @endfor
                                            <span class="ml-2 text-xs text-gray-500">({{ $service->total_reviews }})</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex space-x-2">
                                    <a href="{{ route('catalog.booking', $service) }}" class="flex-1 btn-primary text-white px-4 py-2 rounded-xl text-center text-sm font-medium">
                                        <i class="fab fa-whatsapp mr-2"></i>Pesan via WhatsApp
                                    </a>
                                    <a href="{{ route('services.show', $service) }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-200">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @else
        <!-- Filtered Results -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                Hasil Pencarian 
                @if(request('search'))
                    untuk "{{ request('search') }}"
                @endif
                @if(request('category'))
                    - {{ ucfirst(str_replace('_', ' ', request('category'))) }}
                @endif
            </h2>

            @if($services->isEmpty())
                <div class="glass-effect rounded-2xl p-12 text-center">
                    <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-bold text-gray-400 mb-2">Tidak ada layanan ditemukan</h3>
                    <p class="text-gray-500 mb-6">Coba gunakan kata kunci lain atau pilih kategori berbeda</p>
                    <a href="{{ route('catalog.index') }}" class="btn-primary text-white px-6 py-3 rounded-full font-medium">
                        Lihat Semua Layanan
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($services as $service)
                        <div class="glass-effect rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                            <div class="relative h-48 bg-gradient-to-br from-pink-400 to-orange-400">
                                @if($service->image)
                                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas fa-spa text-white text-5xl opacity-50"></i>
                                    </div>
                                @endif
                                <div class="absolute top-4 right-4">
                                    <span class="px-3 py-1 bg-white bg-opacity-90 text-pink-600 rounded-full text-xs font-bold">
                                        Rp {{ number_format($service->price, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $service->name }}</h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ Str::limit($service->description, 100) }}</p>
                                
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i class="far fa-clock mr-2"></i>
                                        <span>{{ $service->duration }} menit</span>
                                    </div>
                                    @if($service->total_reviews > 0)
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star text-xs {{ $i <= round($service->average_rating) ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                            @endfor
                                            <span class="ml-2 text-xs text-gray-500">({{ $service->total_reviews }})</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex space-x-2">
                                    <a href="{{ route('catalog.booking', $service) }}" class="flex-1 btn-primary text-white px-4 py-2 rounded-xl text-center text-sm font-medium">
                                        <i class="fab fa-whatsapp mr-2"></i>Pesan via WhatsApp
                                    </a>
                                    <a href="{{ route('services.show', $service) }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-200">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $services->links() }}
                </div>
            @endif
        </div>
    @endif
</div>
@endsection

