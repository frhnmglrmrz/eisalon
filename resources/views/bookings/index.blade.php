@extends('layouts.app')

@section('title', 'My Bookings - Ei Salon')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="mb-12 animate-fadeIn">
        <h1 class="text-4xl font-bold gradient-text mb-4">My Bookings</h1>
        <p class="text-gray-600">Manage and track your salon appointments</p>
    </div>
    
    @if($bookings->isEmpty())
        <div class="glass-effect rounded-2xl p-12 text-center">
            <i class="fas fa-calendar-times text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-2xl font-bold text-gray-400 mb-2">No bookings yet</h3>
            <p class="text-gray-500 mb-6">Start booking your favorite treatments today!</p>
            <a href="{{ route('home') }}" class="inline-block btn-primary text-white px-8 py-3 rounded-full font-medium">
                <i class="fas fa-search mr-2"></i>Browse Services
            </a>
        </div>
    @else
        <div class="space-y-6">
            @foreach($bookings as $index => $booking)
                <div class="glass-effect rounded-2xl overflow-hidden shadow-lg animate-fadeIn" style="animation-delay: {{ $index * 0.1 }}s;">
                    <div class="md:flex">
                        <!-- Service Image -->
                        <div class="md:w-64 h-48 md:h-auto bg-gradient-to-br from-pink-400 to-orange-400 relative">
                            @if($booking->service->image)
                                <img src="{{ asset('storage/' . $booking->service->image) }}" alt="{{ $booking->service->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="fas fa-spa text-white text-5xl opacity-50"></i>
                                </div>
                            @endif
                            
                            <!-- Status Badge -->
                            <div class="absolute top-4 left-4">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-500',
                                        'confirmed' => 'bg-green-500',
                                        'in_progress' => 'bg-blue-500',
                                        'completed' => 'bg-gray-500',
                                        'cancelled' => 'bg-red-500',
                                    ];
                                    $color = $statusColors[$booking->status] ?? 'bg-gray-500';
                                @endphp
                                <span class="{{ $color }} text-white px-4 py-2 rounded-full text-sm font-medium">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Booking Details -->
                        <div class="flex-1 p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $booking->service->name }}</h3>
                                    <div class="text-sm text-gray-600 space-y-1">
                                        <div><i class="far fa-calendar mr-2"></i>{{ $booking->booking_date->format('l, d F Y') }}</div>
                                        <div><i class="far fa-clock mr-2"></i>{{ $booking->booking_date->format('H:i') }} WIB</div>
                                        @if($booking->therapist)
                                            <div><i class="fas fa-user-md mr-2"></i>{{ $booking->therapist->name }}</div>
                                        @endif
                                        <div><i class="far fa-hourglass mr-2"></i>{{ $booking->service->duration }} minutes</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-3xl font-bold gradient-text">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                                    
                                    @if($booking->status === 'cancelled')
                                        <div class="text-red-600 text-sm font-medium mt-2">
                                            <i class="fas fa-times-circle mr-1"></i>Cancelled
                                        </div>
                                    @elseif($booking->status === 'completed')
                                        <div class="text-blue-600 text-sm font-medium mt-2">
                                            <i class="fas fa-check-double mr-1"></i>Completed
                                        </div>
                                    @elseif($booking->payment)
                                        @if($booking->payment->status === 'paid')
                                            <div class="text-green-600 text-sm font-medium mt-2">
                                                <i class="fas fa-check-circle mr-1"></i>Paid
                                            </div>
                                        @elseif($booking->payment->status === 'pending')
                                            <div class="text-yellow-600 text-sm font-medium mt-2">
                                                <i class="fas fa-clock mr-1"></i>Pending Payment
                                            </div>
                                        @elseif($booking->payment->status === 'expired')
                                            <div class="text-gray-600 text-sm font-medium mt-2">
                                                <i class="fas fa-history mr-1"></i>Expired
                                            </div>
                                        @elseif($booking->payment->status === 'failed')
                                            <div class="text-red-600 text-sm font-medium mt-2">
                                                <i class="fas fa-exclamation-circle mr-1"></i>Payment Failed
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            
                            @if($booking->notes)
                                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                    <div class="text-sm text-gray-600 mb-1">Special Requests:</div>
                                    <div class="text-gray-800">{{ $booking->notes }}</div>
                                </div>
                            @endif
                            
                            <!-- Actions -->
                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('bookings.show', $booking) }}" class="px-6 py-2 bg-white border-2 border-pink-500 text-pink-500 rounded-full font-medium hover:bg-pink-50 transition">
                                    <i class="fas fa-eye mr-2"></i>View Details
                                </a>
                                
                                @if($booking->payment && $booking->payment->status === 'pending')
                                    <a href="{{ $booking->payment->xendit_invoice_url }}" class="px-6 py-2 btn-primary text-white rounded-full font-medium">
                                        <i class="fas fa-credit-card mr-2"></i>Complete Payment
                                    </a>
                                @endif
                                
                                @if($booking->canBeCancelled())
                                    <form action="{{ route('bookings.cancel', $booking) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Are you sure you want to cancel this booking?')" class="px-6 py-2 bg-red-500 text-white rounded-full font-medium hover:bg-red-600 transition">
                                            <i class="fas fa-times mr-2"></i>Cancel Booking
                                        </button>
                                    </form>
                                @endif
                                
                                @if($booking->status === 'completed' && !$booking->review)
                                    <button onclick="openReviewModal({{ $booking->id }}, '{{ $booking->service->name }}')" class="px-6 py-2 bg-yellow-500 text-white rounded-full font-medium hover:bg-yellow-600 transition">
                                        <i class="fas fa-star mr-2"></i>Leave Review
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-8">
            {{ $bookings->links() }}
        </div>
    @endif
</div>

<!-- Review Modal -->
<div id="review-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 px-6">
    <div class="glass-effect rounded-2xl max-w-lg w-full p-8 animate-fadeIn">
        <h3 class="text-2xl font-bold text-gray-800 mb-4">Leave a Review</h3>
        <p id="review-service-name" class="text-gray-600 mb-6"></p>
        
        <form id="review-form" method="POST">
            @csrf
            
            <!-- Star Rating -->
            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-3">Rating</label>
                <div class="flex gap-2" id="star-rating">
                    @for($i = 1; $i <= 5; $i++)
                        <button type="button" class="star-btn text-4xl text-gray-300 hover:text-yellow-500 transition" data-rating="{{ $i }}">
                            <i class="far fa-star"></i>
                        </button>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="rating-input" required>
            </div>
            
            <!-- Comment -->
            <div class="mb-6">
                <label for="comment" class="block text-gray-700 font-bold mb-3">Comment (Optional)</label>
                <textarea 
                    id="comment" 
                    name="comment" 
                    rows="4" 
                    placeholder="Share your experience..."
                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none transition resize-none"
                ></textarea>
            </div>
            
            <!-- Buttons -->
            <div class="flex gap-3">
                <button type="button" onclick="closeReviewModal()" class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-full font-medium hover:bg-gray-300 transition">
                    Cancel
                </button>
                <button type="submit" class="flex-1 btn-primary text-white px-6 py-3 rounded-full font-medium">
                    Submit Review
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openReviewModal(bookingId, serviceName) {
        document.getElementById('review-service-name').textContent = serviceName;
        document.getElementById('review-form').action = `/bookings/${bookingId}/reviews`;
        document.getElementById('review-modal').classList.remove('hidden');
        document.getElementById('review-modal').classList.add('flex');
    }
    
    function closeReviewModal() {
        document.getElementById('review-modal').classList.add('hidden');
        document.getElementById('review-modal').classList.remove('flex');
        resetStars();
    }
    
    // Star rating functionality
    const starButtons = document.querySelectorAll('.star-btn');
    const ratingInput = document.getElementById('rating-input');
    
    starButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const rating = parseInt(this.dataset.rating);
            ratingInput.value = rating;
            updateStars(rating);
        });
        
        btn.addEventListener('mouseenter', function() {
            const rating = parseInt(this.dataset.rating);
            updateStars(rating);
        });
    });
    
    document.getElementById('star-rating').addEventListener('mouseleave', function() {
        const currentRating = parseInt(ratingInput.value) || 0;
        updateStars(currentRating);
    });
    
    function updateStars(rating) {
        starButtons.forEach((btn, index) => {
            const icon = btn.querySelector('i');
            if (index < rating) {
                icon.classList.remove('far', 'text-gray-300');
                icon.classList.add('fas', 'text-yellow-500');
            } else {
                icon.classList.remove('fas', 'text-yellow-500');
                icon.classList.add('far', 'text-gray-300');
            }
        });
    }
    
    function resetStars() {
        ratingInput.value = '';
        updateStars(0);
    }
    
    // Close modal on outside click
    document.getElementById('review-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeReviewModal();
        }
    });
</script>
@endpush
@endsection
