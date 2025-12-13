@extends('layouts.app')

@section('title', 'Book ' . $service->name . ' - Ei Salon')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="max-w-3xl mx-auto">
        <div class="text-center mb-12 animate-fadeIn">
            <h1 class="text-4xl font-bold gradient-text mb-4">Book Your Appointment</h1>
            <p class="text-gray-600">Complete the form below to book your service</p>
        </div>
        
        <div class="glass-effect rounded-2xl shadow-xl p-8 animate-slideInLeft">
            <!-- Service Summary -->
            <div class="bg-gradient-to-br from-pink-50 to-orange-50 rounded-xl p-6 mb-8">
                <h3 class="font-bold text-gray-800 mb-4 text-xl">Service Details</h3>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <div class="text-sm text-gray-600 mb-1">Service</div>
                        <div class="font-bold text-gray-800">{{ $service->name }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-600 mb-1">Duration</div>
                        <div class="font-bold text-gray-800">{{ $service->duration }} minutes</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-600 mb-1">Category</div>
                        <div class="font-bold text-gray-800">{{ ucwords(str_replace('_', ' ', $service->category)) }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-600 mb-1">Price</div>
                        <div class="text-2xl font-bold gradient-text">Rp {{ number_format($service->price, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
            
            <!-- Booking Form -->
            <form action="{{ route('bookings.store') }}" method="POST" id="booking-form">
                @csrf
                <input type="hidden" name="service_id" value="{{ $service->id }}">
                
                <!-- Therapist Selection -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-3">
                        <i class="fas fa-user-md mr-2"></i>Select Therapist (Optional)
                    </label>
                    <div class="grid md:grid-cols-2 gap-4">
                        <label class="cursor-pointer">
                            <input type="radio" name="therapist_id" value="" class="peer hidden" checked>
                            <div class="glass-effect rounded-xl p-4 border-2 border-transparent peer-checked:border-pink-500 peer-checked:bg-pink-50 transition">
                                <div class="font-bold text-gray-800">Any Available Therapist</div>
                                <div class="text-sm text-gray-600">We'll assign the best available therapist</div>
                            </div>
                        </label>
                        
                        @foreach($therapists as $therapist)
                            <label class="cursor-pointer">
                                <input type="radio" name="therapist_id" value="{{ $therapist->id }}" class="peer hidden">
                                <div class="glass-effect rounded-xl p-4 border-2 border-transparent peer-checked:border-pink-500 peer-checked:bg-pink-50 transition">
                                    <div class="flex items-center mb-2">
                                        <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-orange-500 rounded-full flex items-center justify-center text-white font-bold mr-3">
                                            {{ strtoupper(substr($therapist->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-800">{{ $therapist->name }}</div>
                                            <div class="text-sm text-gray-600">{{ ucwords(str_replace('_', ' ', $therapist->specialization)) }}</div>
                                        </div>
                                    </div>
                                    @if($therapist->bio)
                                        <div class="text-sm text-gray-600 mt-2">{{ $therapist->bio }}</div>
                                    @endif
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
                
                <!-- Date Selection -->
                <div class="mb-6">
                    <label for="booking_date" class="block text-gray-700 font-bold mb-3">
                        <i class="far fa-calendar mr-2"></i>Select Date
                    </label>
                    <input 
                        type="date" 
                        id="booking_date" 
                        name="booking_date_only"
                        min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none transition"
                        required
                    >
                </div>
                
                <!-- Time Slot Selection -->
                <div class="mb-6" id="time-slot-container" style="display: none;">
                    <label class="block text-gray-700 font-bold mb-3">
                        <i class="far fa-clock mr-2"></i>Select Time Slot
                    </label>
                    <div id="time-slots" class="grid grid-cols-3 md:grid-cols-4 gap-3">
                        <!-- Time slots will be populated via JavaScript -->
                    </div>
                    <input type="hidden" name="booking_date" id="booking_datetime" required>
                </div>
                
                <!-- Notes -->
                <div class="mb-6">
                    <label for="notes" class="block text-gray-700 font-bold mb-3">
                        <i class="fas fa-comments mr-2"></i>Special Requests (Optional)
                    </label>
                    <textarea 
                        id="notes" 
                        name="notes" 
                        rows="4" 
                        placeholder="Any special requests or health conditions we should know about?"
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none transition resize-none"
                    ></textarea>
                </div>
                
                <!-- Submit Button -->
                <button 
                    type="submit" 
                    id="submit-btn"
                    class="w-full btn-primary text-white px-8 py-4 rounded-full font-bold text-lg shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                    disabled
                >
                    <i class="fas fa-calendar-check mr-2"></i>Proceed to Payment
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const bookingDateInput = document.getElementById('booking_date');
    const timeSlotContainer = document.getElementById('time-slot-container');
    const timeSlotsDiv = document.getElementById('time-slots');
    const bookingDatetimeInput = document.getElementById('booking_datetime');
    const submitBtn = document.getElementById('submit-btn');
    const therapistInputs = document.querySelectorAll('input[name="therapist_id"]');
    
    let selectedDate = null;
    let selectedTime = null;
    
    // Fetch available time slots
    async function fetchTimeSlots() {
        const date = bookingDateInput.value;
        if (!date) return;
        
        selectedDate = date;
        const therapistId = document.querySelector('input[name="therapist_id"]:checked')?.value || '';
        
        try {
            timeSlotsDiv.innerHTML = '<div class="col-span-full text-center py-4"><i class="fas fa-spinner fa-spin text-2xl text-pink-500"></i></div>';
            timeSlotContainer.style.display = 'block';
            
            const response = await fetch(`{{ route('bookings.available-slots') }}?service_id={{ $service->id }}&therapist_id=${therapistId}&date=${date}`);
            const slots = await response.json();
            
            if (slots.length === 0) {
                timeSlotsDiv.innerHTML = '<div class="col-span-full text-center py-4 text-gray-500">No available time slots for this date</div>';
                return;
            }
            
            timeSlotsDiv.innerHTML = '';
            slots.forEach(slot => {
                const slotBtn = document.createElement('button');
                slotBtn.type = 'button';
                slotBtn.className = 'time-slot-btn px-4 py-3 rounded-xl border-2 border-gray-200 hover:border-pink-500 transition font-medium';
                slotBtn.textContent = slot.time;
                slotBtn.dataset.datetime = slot.datetime;
                
                slotBtn.addEventListener('click', function() {
                    document.querySelectorAll('.time-slot-btn').forEach(btn => {
                        btn.classList.remove('bg-pink-500', 'text-white', 'border-pink-500');
                        btn.classList.add('border-gray-200');
                    });
                    
                    this.classList.add('bg-pink-500', 'text-white', 'border-pink-500');
                    this.classList.remove('border-gray-200');
                    
                    selectedTime = this.dataset.datetime;
                    bookingDatetimeInput.value = selectedTime;
                    submitBtn.disabled = false;
                });
                
                timeSlotsDiv.appendChild(slotBtn);
            });
        } catch (error) {
            console.error('Error fetching time slots:', error);
            timeSlotsDiv.innerHTML = '<div class="col-span-full text-center py-4 text-red-500">Error loading time slots</div>';
        }
    }
    
    // Event listeners
    bookingDateInput.addEventListener('change', fetchTimeSlots);
    therapistInputs.forEach(input => {
        input.addEventListener('change', () => {
            if (selectedDate) {
                fetchTimeSlots();
            }
        });
    });
    
    // Form validation
    document.getElementById('booking-form').addEventListener('submit', function(e) {
        if (!bookingDatetimeInput.value) {
            e.preventDefault();
            alert('Please select a time slot');
        }
    });
</script>
@endpush
@endsection
