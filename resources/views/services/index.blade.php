@extends('layouts.app')

@section('title', 'Our Services - Ei Salon')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden bg-gradient-to-br from-pink-50 via-white to-orange-50 py-20">
    <div class="container mx-auto px-6">
        <div class="text-center animate-fadeIn">
            <h1 class="text-5xl md:text-6xl font-bold gradient-text mb-6">
                Discover Your Beauty
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                Experience luxury treatments and professional care at Ei Salon
            </p>
            
            <!-- Search & Filter -->
            <div class="max-w-4xl mx-auto glass-effect rounded-full p-2 shadow-lg">
                <form method="GET" action="{{ route('home') }}" class="flex flex-col md:flex-row gap-2">
                    <div class="flex-1 relative">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Search services..." 
                            value="{{ request('search') }}"
                            class="w-full pl-12 pr-4 py-3 rounded-full bg-white focus:outline-none focus:ring-2 focus:ring-pink-400"
                        >
                    </div>
                    <select 
                        name="category" 
                        class="px-6 py-3 rounded-full bg-white focus:outline-none focus:ring-2 focus:ring-pink-400"
                        onchange="this.form.submit()"
                    >
                        <option value="">All Categories</option>
                        <option value="facial" {{ request('category') == 'facial' ? 'selected' : '' }}>Facial</option>
                        <option value="massage" {{ request('category') == 'massage' ? 'selected' : '' }}>Massage</option>
                        <option value="hair_treatment" {{ request('category') == 'hair_treatment' ? 'selected' : '' }}>Hair Treatment</option>
                        <option value="body_treatment" {{ request('category') == 'body_treatment' ? 'selected' : '' }}>Body Treatment</option>
                        <option value="nail_care" {{ request('category') == 'nail_care' ? 'selected' : '' }}>Nail Care</option>
                    </select>
                    <button type="submit" class="btn-primary text-white px-8 py-3 rounded-full font-medium">
                        <i class="fas fa-search mr-2"></i>Search
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Floating elements -->
    <div class="absolute top-20 left-10 w-20 h-20 bg-pink-300 rounded-full opacity-20 animate-float"></div>
    <div class="absolute bottom-20 right-10 w-32 h-32 bg-orange-300 rounded-full opacity-20 animate-float" style="animation-delay: 1s;"></div>
</div>

<!-- Services Grid -->
<div class="container mx-auto px-6 py-16">
    @if($services->isEmpty())
        <div class="text-center py-20">
            <i class="fas fa-spa text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-2xl font-bold text-gray-400 mb-2">No services found</h3>
            <p class="text-gray-500">Try adjusting your search or filter</p>
        </div>
    @else
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($services as $index => $service)
                <div class="glass-effect rounded-2xl overflow-hidden shadow-lg card-hover animate-fadeIn" style="animation-delay: {{ $index * 0.1 }}s;">
                    <!-- Service Image -->
                    <div class="relative h-64 bg-gradient-to-br from-pink-400 to-orange-400 overflow-hidden">
                        @if($service->image)
                            <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fas fa-spa text-white text-6xl opacity-50"></i>
                            </div>
                        @endif
                        
                        <!-- Category Badge -->
                        <div class="absolute top-4 left-4">
                            <span class="glass-effect px-4 py-2 rounded-full text-sm font-medium text-gray-800">
                                {{ ucwords(str_replace('_', ' ', $service->category)) }}
                            </span>
                        </div>
                        
                        <!-- Rating -->
                        @if($service->total_reviews > 0)
                            <div class="absolute top-4 right-4 glass-effect px-3 py-2 rounded-full">
                                <i class="fas fa-star text-yellow-500 mr-1"></i>
                                <span class="font-bold">{{ number_format($service->average_rating, 1) }}</span>
                                <span class="text-sm text-gray-600">({{ $service->total_reviews }})</span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Service Info -->
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $service->name }}</h3>
                        <p class="text-gray-600 mb-4 line-clamp-2">{{ $service->description }}</p>
                        
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <span class="text-3xl font-bold gradient-text">
                                    Rp {{ number_format($service->price, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="text-gray-500">
                                <i class="far fa-clock mr-1"></i>
                                {{ $service->duration }} min
                            </div>
                        </div>
                        
                        <div class="flex gap-2">
                            <a href="{{ route('services.show', $service) }}" class="flex-1 text-center bg-white border-2 border-pink-500 text-pink-500 px-6 py-3 rounded-full font-medium hover:bg-pink-50 transition">
                                Details
                            </a>
                            <a href="{{ route('bookings.create', ['service_id' => $service->id]) }}" class="flex-1 text-center btn-primary text-white px-6 py-3 rounded-full font-medium">
                                Book Now
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-12">
            {{ $services->links() }}
        </div>
    @endif
</div>

<!-- Features Section -->
<div class="glass-effect py-16">
    <div class="container mx-auto px-6">
        <div class="grid md:grid-cols-4 gap-8 text-center">
            <div class="animate-fadeIn">
                <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-md text-white text-2xl"></i>
                </div>
                <h4 class="font-bold text-gray-800 mb-2">Professional Team</h4>
                <p class="text-gray-600">Certified and experienced therapists</p>
            </div>
            
            <div class="animate-fadeIn" style="animation-delay: 0.1s;">
                <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-alt text-white text-2xl"></i>
                </div>
                <h4 class="font-bold text-gray-800 mb-2">Safe & Hygienic</h4>
                <p class="text-gray-600">Sterilized tools and equipment</p>
            </div>
            
            <div class="animate-fadeIn" style="animation-delay: 0.2s;">
                <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-leaf text-white text-2xl"></i>
                </div>
                <h4 class="font-bold text-gray-800 mb-2">Natural Products</h4>
                <p class="text-gray-600">Premium organic ingredients</p>
            </div>
            
            <div class="animate-fadeIn" style="animation-delay: 0.3s;">
                <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-credit-card text-white text-2xl"></i>
                </div>
                <h4 class="font-bold text-gray-800 mb-2">Easy Payment</h4>
                <p class="text-gray-600">Multiple payment options</p>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush
@endsection
