@extends('layouts.app')

@section('title', $service->name . ' - Ei Salon')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="grid lg:grid-cols-2 gap-12">
        <!-- Service Image -->
        <div class="animate-slideInLeft">
            <div class="relative h-96 lg:h-full rounded-2xl overflow-hidden shadow-2xl">
                @if($service->image)
                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-pink-400 to-orange-400 flex items-center justify-center">
                        <i class="fas fa-spa text-white text-9xl opacity-50"></i>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Service Details -->
        <div class="animate-slideInRight">
            <!-- Category Badge -->
            <div class="inline-block glass-effect px-4 py-2 rounded-full text-sm font-medium text-gray-800 mb-4">
                {{ ucwords(str_replace('_', ' ', $service->category)) }}
            </div>
            
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">{{ $service->name }}</h1>
            
            <!-- Rating -->
            @if($service->total_reviews > 0)
                <div class="flex items-center mb-6">
                    <div class="flex text-yellow-500 mr-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($service->average_rating))
                                <i class="fas fa-star"></i>
                            @elseif($i - 0.5 <= $service->average_rating)
                                <i class="fas fa-star-half-alt"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="font-bold text-gray-800">{{ number_format($service->average_rating, 1) }}</span>
                    <span class="text-gray-600 ml-2">({{ $service->total_reviews }} reviews)</span>
                </div>
            @endif
            
            <!-- Description -->
            <p class="text-gray-600 text-lg mb-8 leading-relaxed">{{ $service->description }}</p>
            
            <!-- Service Details -->
            <div class="glass-effect rounded-2xl p-6 mb-8">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <div class="text-gray-500 mb-2">
                            <i class="far fa-clock mr-2"></i>Duration
                        </div>
                        <div class="text-xl font-bold text-gray-800">{{ $service->duration }} minutes</div>
                    </div>
                    <div>
                        <div class="text-gray-500 mb-2">
                            <i class="fas fa-tag mr-2"></i>Price
                        </div>
                        <div class="text-3xl font-bold gradient-text">Rp {{ number_format($service->price, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
            
            <!-- Book Button -->
            <a href="{{ route('bookings.create', ['service_id' => $service->id]) }}" class="block w-full text-center btn-primary text-white px-8 py-4 rounded-full font-bold text-lg shadow-lg">
                <i class="fas fa-calendar-check mr-2"></i>Book This Service
            </a>
        </div>
    </div>
    
    <!-- Reviews Section -->
    @if($service->reviews->count() > 0)
        <div class="mt-16">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Customer Reviews</h2>
            <div class="grid md:grid-cols-2 gap-6">
                @foreach($service->reviews as $review)
                    <div class="glass-effect rounded-2xl p-6 animate-fadeIn">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-orange-500 rounded-full flex items-center justify-center text-white font-bold mr-4">
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-bold text-gray-800">{{ $review->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                            <div class="flex text-yellow-500">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        @if($review->comment)
                            <p class="text-gray-600">{{ $review->comment }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    
    <!-- Related Services -->
    @if($relatedServices->count() > 0)
        <div class="mt-16">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">You May Also Like</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedServices as $relatedService)
                    <a href="{{ route('services.show', $relatedService) }}" class="glass-effect rounded-2xl overflow-hidden shadow-lg card-hover">
                        <div class="relative h-48 bg-gradient-to-br from-pink-400 to-orange-400">
                            @if($relatedService->image)
                                <img src="{{ asset('storage/' . $relatedService->image) }}" alt="{{ $relatedService->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="fas fa-spa text-white text-4xl opacity-50"></i>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-gray-800 mb-2">{{ $relatedService->name }}</h3>
                            <div class="text-xl font-bold gradient-text">Rp {{ number_format($relatedService->price, 0, ',', '.') }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
