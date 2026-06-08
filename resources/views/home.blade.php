@extends('layouts.app')

@section('title', 'Welcome to Ei Salon - Beauty & Wellness')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-br from-pink-50 via-white to-orange-50 py-20 md:py-32">
    <div class="container mx-auto px-6">
        <div class="max-w-4xl mx-auto text-center animate-fadeIn">
            <h1 class="text-5xl md:text-7xl font-bold gradient-text mb-6">
                Welcome to Ei Salon
            </h1>
            <p class="text-xl md:text-2xl text-gray-600 mb-8 leading-relaxed">
                Your premium destination for beauty and wellness. Experience luxury treatments 
                and professional care that brings out your natural glow.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('services.index') }}" class="btn-primary text-white px-8 py-4 rounded-full font-medium text-lg">
                    <i class="fas fa-spa mr-2"></i>Explore Services
                </a>
                <a href="{{ route('catalog.index') }}" class="bg-white border-2 border-pink-500 text-pink-500 px-8 py-4 rounded-full font-medium text-lg hover:bg-pink-50 transition">
                    <i class="fas fa-book mr-2"></i>View Catalog
                </a>
            </div>
        </div>
    </div>
    
    <!-- Floating decorative elements -->
    <div class="absolute top-20 left-10 w-20 h-20 bg-pink-300 rounded-full opacity-20 animate-float"></div>
    <div class="absolute bottom-20 right-10 w-32 h-32 bg-orange-300 rounded-full opacity-20 animate-float" style="animation-delay: 1s;"></div>
    <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-pink-200 rounded-full opacity-30 animate-float" style="animation-delay: 2s;"></div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="animate-fadeIn">
                <div class="text-4xl md:text-5xl font-bold gradient-text mb-2"><span id="stat-services">{{ $stats['total_services'] }}</span>+</div>
                <p class="text-gray-600 font-medium">Services</p>
            </div>
            <div class="animate-fadeIn" style="animation-delay: 0.1s;">
                <div class="text-4xl md:text-5xl font-bold gradient-text mb-2"><span id="stat-categories">{{ $stats['categories'] }}</span></div>
                <p class="text-gray-600 font-medium">Categories</p>
            </div>
            <div class="animate-fadeIn" style="animation-delay: 0.2s;">
                <div class="text-4xl md:text-5xl font-bold gradient-text mb-2"><span id="stat-rating">{{ number_format($stats['average_rating'], 1) }}</span></div>
                <p class="text-gray-600 font-medium">Average Rating</p>
            </div>
            <div class="animate-fadeIn" style="animation-delay: 0.3s;">
                <div class="text-4xl md:text-5xl font-bold gradient-text mb-2"><span id="stat-reviews">{{ $stats['total_reviews'] }}</span>+</div>
                <p class="text-gray-600 font-medium">Happy Clients</p>
            </div>
        </div>
    </div>
</section>

<!-- About Us Section -->
<section id="about" class="py-20 bg-gradient-to-br from-pink-50 via-white to-orange-50">
    <div class="container mx-auto px-6">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16 animate-fadeIn">
                <h2 class="text-4xl md:text-5xl font-bold gradient-text mb-4">About Ei Salon</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-pink-500 to-orange-500 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    We are dedicated to providing exceptional beauty and wellness services 
                    that help you look and feel your best.
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="animate-slideInLeft">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-pink-400 to-orange-400 rounded-3xl transform rotate-3"></div>
                        <div class="relative bg-white rounded-3xl p-8 shadow-2xl">
                            <h3 class="text-3xl font-bold text-gray-800 mb-4">Our Story</h3>
                            <p class="text-gray-600 mb-4 leading-relaxed">
                                Ei Salon was founded with a vision to create a sanctuary where beauty meets wellness. 
                                We believe that everyone deserves to feel confident and radiant in their own skin.
                            </p>
                            <p class="text-gray-600 mb-4 leading-relaxed">
                                With years of experience and a passion for excellence, our team of certified therapists 
                                is committed to delivering personalized treatments that exceed expectations.
                            </p>
                            <div class="flex items-center gap-4 mt-6">
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 text-xl mr-2"></i>
                                    <span class="text-gray-700 font-medium">Certified Therapists</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 text-xl mr-2"></i>
                                    <span class="text-gray-700 font-medium">Premium Products</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="animate-slideInRight space-y-6">
                    <div class="glass-effect rounded-2xl p-6 card-hover">
                        <div class="flex items-start">
                            <div class="w-14 h-14 bg-gradient-to-br from-pink-500 to-orange-500 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-heart text-white text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-800 mb-2">Our Mission</h4>
                                <p class="text-gray-600">
                                    To provide exceptional beauty and wellness services that enhance your natural beauty 
                                    and promote overall well-being.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="glass-effect rounded-2xl p-6 card-hover">
                        <div class="flex items-start">
                            <div class="w-14 h-14 bg-gradient-to-br from-pink-500 to-orange-500 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-eye text-white text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-800 mb-2">Our Vision</h4>
                                <p class="text-gray-600">
                                    To be the leading beauty and wellness destination known for innovation, 
                                    quality, and exceptional customer care.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="glass-effect rounded-2xl p-6 card-hover">
                        <div class="flex items-start">
                            <div class="w-14 h-14 bg-gradient-to-br from-pink-500 to-orange-500 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-gem text-white text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-800 mb-2">Our Values</h4>
                                <p class="text-gray-600">
                                    Excellence, integrity, and personalized care are at the heart of everything we do. 
                                    Your satisfaction is our priority.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Services Section -->
<section id="services" class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16 animate-fadeIn">
            <h2 class="text-4xl md:text-5xl font-bold gradient-text mb-4">Our Featured Services</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-pink-500 to-orange-500 mx-auto mb-6"></div>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Discover our most popular treatments designed to rejuvenate and pamper you
            </p>
        </div>
        
        @if($featuredServices->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach($featuredServices as $index => $service)
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
                                </div>
                            @endif
                        </div>
                        
                        <!-- Service Info -->
                        <div class="p-6">
                            <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $service->name }}</h3>
                            <p class="text-gray-600 mb-4 line-clamp-2">{{ Str::limit($service->description, 100) }}</p>
                            
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
                                <a href="{{ route('services.show', $service) }}" class="flex-1 text-center bg-white border-2 border-pink-500 text-pink-500 px-4 py-3 rounded-full font-medium hover:bg-pink-50 transition">
                                    Details
                                </a>
                                @auth
                                    <a href="{{ route('bookings.create', ['service_id' => $service->id]) }}" class="flex-1 text-center btn-primary text-white px-4 py-3 rounded-full font-medium">
                                        Book Now
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="flex-1 text-center btn-primary text-white px-4 py-3 rounded-full font-medium">
                                        Book Now
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="text-center">
                <a href="{{ route('services.index') }}" class="inline-block bg-white border-2 border-pink-500 text-pink-500 px-8 py-4 rounded-full font-medium text-lg hover:bg-pink-50 transition">
                    View All Services <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-spa text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg">Services coming soon...</p>
            </div>
        @endif
    </div>
</section>

<!-- Features/Benefits Section -->
<section class="py-20 bg-gradient-to-br from-pink-50 via-white to-orange-50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16 animate-fadeIn">
            <h2 class="text-4xl md:text-5xl font-bold gradient-text mb-4">Why Choose Ei Salon?</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-pink-500 to-orange-500 mx-auto mb-6"></div>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="glass-effect rounded-2xl p-8 text-center card-hover animate-fadeIn">
                <div class="w-20 h-20 bg-gradient-to-br from-pink-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-user-md text-white text-3xl"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-800 mb-3">Professional Team</h4>
                <p class="text-gray-600">
                    Our certified and experienced therapists are dedicated to providing you with the best care.
                </p>
            </div>
            
            <div class="glass-effect rounded-2xl p-8 text-center card-hover animate-fadeIn" style="animation-delay: 0.1s;">
                <div class="w-20 h-20 bg-gradient-to-br from-pink-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-shield-alt text-white text-3xl"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-800 mb-3">Safe & Hygienic</h4>
                <p class="text-gray-600">
                    We maintain the highest standards of hygiene with sterilized tools and sanitized equipment.
                </p>
            </div>
            
            <div class="glass-effect rounded-2xl p-8 text-center card-hover animate-fadeIn" style="animation-delay: 0.2s;">
                <div class="w-20 h-20 bg-gradient-to-br from-pink-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-leaf text-white text-3xl"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-800 mb-3">Natural Products</h4>
                <p class="text-gray-600">
                    We use premium organic ingredients that are gentle on your skin and hair.
                </p>
            </div>
            
            <div class="glass-effect rounded-2xl p-8 text-center card-hover animate-fadeIn" style="animation-delay: 0.3s;">
                <div class="w-20 h-20 bg-gradient-to-br from-pink-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-clock text-white text-3xl"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-800 mb-3">Flexible Booking</h4>
                <p class="text-gray-600">
                    Book your appointments online at your convenience. Easy scheduling and reminders.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
@if($testimonials->count() > 0)
<section id="testimonials" class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16 animate-fadeIn">
            <h2 class="text-4xl md:text-5xl font-bold gradient-text mb-4">What Our Clients Say</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-pink-500 to-orange-500 mx-auto mb-6"></div>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Read what our satisfied customers have to say about their experience
            </p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
            @foreach($testimonials as $index => $review)
                <div class="glass-effect rounded-2xl p-8 card-hover animate-fadeIn" style="animation-delay: {{ $index * 0.1 }}s;">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-orange-500 rounded-full flex items-center justify-center text-white font-bold mr-4">
                            {{ strtoupper(substr($review->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <h5 class="font-bold text-gray-800">{{ $review->user->name }}</h5>
                            <p class="text-sm text-gray-500">{{ $review->service->name }}</p>
                        </div>
                    </div>
                    
                    <div class="flex mb-4">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-500' : 'text-gray-300' }}"></i>
                        @endfor
                    </div>
                    
                    <p class="text-gray-600 italic">
                        "{{ Str::limit($review->comment ?? 'Great service!', 150) }}"
                    </p>
                    
                    <p class="text-sm text-gray-400 mt-4">
                        {{ $review->created_at->diffForHumans() }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Contact Section -->
<section id="contact" class="py-20 bg-gradient-to-br from-pink-50 via-white to-orange-50">
    <div class="container mx-auto px-6">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-16 animate-fadeIn">
                <h2 class="text-4xl md:text-5xl font-bold gradient-text mb-4">Get In Touch</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-pink-500 to-orange-500 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600">
                    Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8 mb-12">
                <div class="glass-effect rounded-2xl p-6 text-center card-hover animate-fadeIn">
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-phone text-white text-xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-800 mb-2">Phone</h4>
                    <p class="text-gray-600">+62 xxx xxxx xxxx</p>
                </div>
                
                <div class="glass-effect rounded-2xl p-6 text-center card-hover animate-fadeIn" style="animation-delay: 0.1s;">
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-envelope text-white text-xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-800 mb-2">Email</h4>
                    <p class="text-gray-600">info@eisalon.com</p>
                </div>
                
                <div class="glass-effect rounded-2xl p-6 text-center card-hover animate-fadeIn" style="animation-delay: 0.2s;">
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-map-marker-alt text-white text-xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-800 mb-2">Location</h4>
                    <p class="text-gray-600">Jakarta, Indonesia</p>
                </div>
            </div>
            
            <div class="glass-effect rounded-2xl p-8 animate-fadeIn">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Business Hours</h3>
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="flex justify-between items-center p-4 bg-white rounded-lg">
                        <span class="font-medium text-gray-700">Monday - Friday</span>
                        <span class="text-gray-600">9:00 AM - 9:00 PM</span>
                    </div>
                    <div class="flex justify-between items-center p-4 bg-white rounded-lg">
                        <span class="font-medium text-gray-700">Saturday - Sunday</span>
                        <span class="text-gray-600">10:00 AM - 8:00 PM</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .stat-update {
        animation: pulse-green 1s;
    }
    @keyframes pulse-green {
        0% { color: #10B981; transform: scale(1.1); }
        100% { color: inherit; transform: scale(1); }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Real-time polling for home stats
        setInterval(() => {
            fetch('{{ route('home.api-stats') }}')
                .then(response => response.json())
                .then(data => {
                    const stats = data.stats;
                    
                    const updateStat = (id, newValue) => {
                        const el = document.getElementById(id);
                        if (el && el.innerText != newValue) {
                            el.innerText = newValue;
                            el.classList.remove('stat-update');
                            void el.offsetWidth; // trigger reflow
                            el.classList.add('stat-update');
                        }
                    };

                    updateStat('stat-services', stats.total_services);
                    updateStat('stat-categories', stats.categories);
                    
                    // Format rating to 1 decimal place
                    const formattedRating = parseFloat(stats.average_rating).toFixed(1);
                    updateStat('stat-rating', formattedRating);
                    
                    updateStat('stat-reviews', stats.total_reviews);
                })
                .catch(err => console.error('Error fetching stats:', err));
        }, 5000); // Poll every 5 seconds
    });
</script>
@endpush
@endsection

