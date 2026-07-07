@extends('layouts.app')

@section('title', 'Buat Reservasi - Alan\'s Art Hair Salon')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="max-w-4xl mx-auto animate-fadeIn">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold gradient-text mb-4">Buat Reservasi Jadwal</h1>
            <p class="text-gray-600">Nikmati pelayanan rambut premium dengan stylist profesional kami</p>
        </div>

        @if($errors->any())
            <div class="mb-8 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-2xl shadow-sm">
                <div class="font-semibold mb-1 flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2 text-red-600"></i>
                    Terdapat kesalahan pada input Anda:
                </div>
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Reservasi -->
            <div class="lg:col-span-2 space-y-8">
                <form action="{{ route('booking.store') }}" method="POST" id="booking-form" class="glass-effect rounded-2xl p-8 shadow-xl space-y-6" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Pilihan Layanan -->
                    <div>
                        <label for="service_id" class="block text-gray-700 font-bold mb-2">
                            <i class="fas fa-cut text-indigo-600 mr-2"></i>Pilih Layanan <span class="text-red-500">*</span>
                        </label>
                        <select id="service_id" name="service_id" required 
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:outline-none transition">
                            <option value="" disabled selected>-- Pilih Layanan Salon --</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" 
                                        data-price="{{ $service->price }}" 
                                        data-duration="{{ $service->duration_minutes }}"
                                        data-category="{{ $service->category }}"
                                        data-desc="{{ $service->description }}"
                                        {{ (old('service_id') == $service->id || $selectedServiceId == $service->id) ? 'selected' : '' }}>
                                    {{ $service->name }} (Rp {{ number_format($service->price, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                    </div>



                    <!-- Pilih Stylist -->
                    @php
                        $stylists = \App\Models\Stylist::available()->get();
                    @endphp
                    <div class="border-t border-gray-100 pt-6" id="stylist-section" style="display: none;">
                        <label class="block text-gray-700 font-bold mb-3">
                            <i class="fas fa-user-friends text-indigo-600 mr-2"></i>Pilih Stylist (Opsional)
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="stylists-grid">
                            <!-- Opsi Pilih Acak -->
                            <label class="cursor-pointer">
                                <input type="radio" name="stylist_id" value="" class="peer hidden" checked>
                                <div class="glass-effect rounded-xl p-4 border-2 border-transparent peer-checked:border-indigo-600 peer-checked:bg-indigo-50/50 hover:bg-gray-50/50 transition h-full flex flex-col justify-center">
                                    <div class="font-bold text-gray-800">Pilih Siapa Saja (Acak)</div>
                                    <div class="text-xs text-gray-500 mt-1">Kami akan memilihkan stylist terbaik yang tersedia untuk Anda.</div>
                                </div>
                            </label>

                            <!-- Stylist terdaftar -->
                            @foreach($stylists as $stylist)
                                <label class="cursor-pointer stylist-card" data-specialization="{{ $stylist->specialization }}">
                                    <input type="radio" name="stylist_id" value="{{ $stylist->id }}" class="peer hidden" {{ old('stylist_id') == $stylist->id ? 'checked' : '' }}>
                                    <div class="glass-effect rounded-xl p-4 border-2 border-transparent peer-checked:border-indigo-600 peer-checked:bg-indigo-50/50 hover:bg-gray-50/50 transition h-full">
                                        <div class="flex items-center space-x-3">
                                            @if($stylist->photo)
                                                <img src="{{ asset('storage/' . $stylist->photo) }}" alt="{{ $stylist->name }}" class="w-12 h-12 rounded-full object-cover shadow-sm">
                                            @else
                                                <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-sm">
                                                    {{ strtoupper(substr($stylist->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-bold text-gray-800">{{ $stylist->name }}</div>
                                                <div class="text-xs text-gray-500 font-semibold">{{ $stylist->specialization }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Pilih Tanggal -->
                    <div class="border-t border-gray-100 pt-6" id="date-section" style="display: none;">
                        <label for="booking_date" class="block text-gray-700 font-bold mb-2">
                            <i class="far fa-calendar-alt text-indigo-600 mr-2"></i>Pilih Tanggal Reservasi <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="booking_date" name="date" value="{{ old('date') }}" required min="{{ date('Y-m-d') }}"
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:outline-none transition">
                    </div>

                    <!-- Pilih Slot Waktu -->
                    <div class="border-t border-gray-100 pt-6" id="slot-section" style="display: none;">
                        <label class="block text-gray-700 font-bold mb-3">
                            <i class="far fa-clock text-indigo-600 mr-2"></i>Pilih Jam Layanan <span class="text-red-500">*</span>
                        </label>
                        <div id="slots-loading" class="text-center py-6 hidden">
                            <i class="fas fa-spinner fa-spin text-2xl text-indigo-600 mb-2"></i>
                            <p class="text-xs text-gray-500">Memeriksa ketersediaan jadwal...</p>
                        </div>
                        <div id="slots-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                            <!-- Dynamic elements -->
                        </div>
                        <input type="hidden" name="slot_id" id="selected_slot_id" value="{{ old('slot_id') }}">
                    </div>

                    <!-- Catatan Tambahan -->
                    <div class="border-t border-gray-100 pt-6">
                        <label for="notes" class="block text-gray-700 font-bold mb-2">
                            <i class="far fa-comment-dots text-indigo-600 mr-2"></i>Catatan Tambahan (Opsional)
                        </label>
                        <textarea id="notes" name="notes" rows="3" 
                                  class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:outline-none transition resize-none"
                                  placeholder="Contoh: Permintaan potongan khusus, preferensi tertentu, dll...">{{ old('notes') }}</textarea>
                    </div>

                    <!-- Bukti Pembayaran -->
                    <div class="border-t border-gray-100 pt-6">
                        <label for="payment_proof" class="block text-gray-700 font-bold mb-2">
                            <i class="fas fa-receipt text-indigo-600 mr-2"></i>Upload Bukti Pembayaran <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1 flex items-center justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-indigo-500 transition">
                            <div class="space-y-1 text-center">
                                <i class="fas fa-file-image text-gray-400 text-3xl mb-3"></i>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="payment_proof" class="relative cursor-pointer bg-white rounded-md font-semibold text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                        <span>Unggah gambar bukti transfer</span>
                                        <input id="payment_proof" name="payment_proof" type="file" class="sr-only" accept="image/*" required>
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, JPEG up to 2MB</p>
                            </div>
                        </div>
                        <div id="payment-proof-preview-container" class="mt-4 hidden text-center">
                            <span class="text-xs text-gray-500 block mb-2">Pratinjau Gambar:</span>
                            <img id="payment-proof-preview" src="#" alt="Pratinjau Bukti Pembayaran" class="mx-auto max-h-48 rounded-lg shadow-sm border border-gray-200">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="btn-submit" disabled
                            class="w-full btn-primary text-white py-4 rounded-full font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-calendar-check mr-2"></i>Buat Reservasi Sekarang
                    </button>
                </form>
            </div>

            <!-- Panel Rangkuman Booking -->
            <div class="lg:col-span-1">
                <div class="glass-effect rounded-2xl p-6 shadow-xl sticky top-28 space-y-6">
                    <h3 class="text-xl font-bold text-gray-800 border-b border-gray-100 pb-3">Rangkuman Reservasi</h3>
                    
                    <div class="space-y-4">
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-500 uppercase font-semibold">Layanan</span>
                            <span id="summary-service" class="font-bold text-gray-800 text-sm">Belum memilih layanan</span>
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Durasi:</span>
                            <span id="summary-duration" class="font-semibold text-gray-800">-</span>
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Kategori:</span>
                            <span id="summary-category" class="font-semibold text-gray-800">-</span>
                        </div>

                        <div class="flex flex-col border-t border-gray-100 pt-3">
                            <span class="text-xs text-gray-500 uppercase font-semibold">Stylist Pilihan</span>
                            <span id="summary-stylist" class="font-bold text-gray-800 text-sm">Pilih Siapa Saja (Acak)</span>
                        </div>

                        <div class="flex flex-col border-t border-gray-100 pt-3">
                            <span class="text-xs text-gray-500 uppercase font-semibold">Jadwal Pertemuan</span>
                            <span id="summary-date-time" class="font-bold text-indigo-900 text-sm">Belum memilih jadwal</span>
                        </div>

                        <div class="border-t border-gray-100 pt-4 flex justify-between items-center">
                            <span class="font-bold text-gray-800">Total Harga:</span>
                            <span id="summary-price" class="text-xl font-bold gradient-text">Rp 0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const serviceSelect = document.getElementById('service_id');
        const dateInput = document.getElementById('booking_date');
        const stylistsGrid = document.getElementById('stylists-grid');
        const slotsGrid = document.getElementById('slots-grid');
        const slotsLoading = document.getElementById('slots-loading');
        const selectedSlotInput = document.getElementById('selected_slot_id');
        const btnSubmit = document.getElementById('btn-submit');

        // Elements for Summary Panel
        const summaryService = document.getElementById('summary-service');
        const summaryDuration = document.getElementById('summary-duration');
        const summaryCategory = document.getElementById('summary-category');
        const summaryStylist = document.getElementById('summary-stylist');
        const summaryDateTime = document.getElementById('summary-date-time');
        const summaryPrice = document.getElementById('summary-price');

        let selectedDate = dateInput.value;
        let selectedSlotId = selectedSlotInput.value;

        // 1. Event: Ketika Layanan Dipilih
        serviceSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (!selectedOption.value) return;

            const name = selectedOption.text.split(' (')[0];
            const price = parseFloat(selectedOption.getAttribute('data-price'));
            const duration = selectedOption.getAttribute('data-duration');
            const category = selectedOption.getAttribute('data-category');

            // Update Rangkuman
            summaryService.textContent = name;
            summaryDuration.textContent = duration + ' Menit';
            summaryCategory.textContent = category;
            summaryPrice.textContent = 'Rp ' + price.toLocaleString('id-ID');

            // Tampilkan Section Stylist & Date
            document.getElementById('stylist-section').style.display = 'block';
            document.getElementById('date-section').style.display = 'block';

            // Filter Stylist Berdasarkan Kategori Layanan
            filterStylists(category);

            // Reset Slots
            resetSlots();
            checkFormValidity();
        });

        // Fungsi Filter Stylist
        function filterStylists(category) {
            const stylistCards = document.querySelectorAll('.stylist-card');
            let hasStylistForCategory = false;

            stylistCards.forEach(card => {
                const spec = card.getAttribute('data-specialization');
                // Jika spesialisasi mengandung kategori atau kosong/umum
                if (!spec || spec.toLowerCase().includes(category.toLowerCase())) {
                    card.style.display = 'block';
                    hasStylistForCategory = true;
                } else {
                    card.style.display = 'none';
                    // Reset input radio jika disembunyikan
                    const radio = card.querySelector('input[type="radio"]');
                    if (radio.checked) {
                        document.querySelector('input[name="stylist_id"][value=""]').checked = true;
                        summaryStylist.textContent = 'Pilih Siapa Saja (Acak)';
                    }
                }
            });

            // Trigger slot check if date is already set
            if (dateInput.value) {
                fetchAvailableSlots();
            }
        }

        // 2. Event: Ketika Stylist Dipilih
        document.querySelectorAll('input[name="stylist_id"]').forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    if (this.value === '') {
                        summaryStylist.textContent = 'Pilih Siapa Saja (Acak)';
                    } else {
                        const card = this.closest('.stylist-card');
                        const name = card.querySelector('.font-bold').textContent;
                        summaryStylist.textContent = name;
                    }
                    
                    if (dateInput.value) {
                        fetchAvailableSlots();
                    }
                }
            });
        });

        // 3. Event: Ketika Tanggal Dipilih
        dateInput.addEventListener('change', function() {
            selectedDate = this.value;
            if (selectedDate && serviceSelect.value) {
                fetchAvailableSlots();
            } else {
                resetSlots();
            }
        });

        // 4. API: Ambil Slot yang Tersedia
        async function fetchAvailableSlots() {
            const serviceId = serviceSelect.value;
            const stylistEl = document.querySelector('input[name="stylist_id"]:checked');
            const stylistId = stylistEl ? stylistEl.value : '';
            const date = dateInput.value;

            if (!date || !serviceId) return;

            slotsGrid.innerHTML = '';
            slotsLoading.classList.remove('hidden');
            document.getElementById('slot-section').style.display = 'block';
            btnSubmit.disabled = true;

            try {
                const url = `{{ route('slots.available', [], false) }}?date=${date}&service_id=${serviceId}&stylist_id=${stylistId}`;
                const response = await fetch(url);
                const data = await response.json();

                slotsLoading.classList.add('hidden');

                if (data.slots && data.slots.length > 0) {
                    data.slots.forEach(slot => {
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.className = 'px-4 py-3 rounded-xl border-2 font-semibold text-sm transition text-center ';

                        if (slot.is_available) {
                            btn.className += 'border-gray-200 hover:border-indigo-600 hover:bg-indigo-50/20 text-gray-800 cursor-pointer';
                            btn.textContent = slot.start_time;
                            btn.dataset.id = slot.id;
                            
                            // Jika slot_id lama cocok (misal dari request/old)
                            if (selectedSlotId == slot.id) {
                                btn.className += ' border-indigo-600 bg-indigo-50/50';
                                updateDateTimeSummary(date, slot.start_time);
                            }

                            btn.addEventListener('click', function() {
                                // Reset semua style button slot
                                document.querySelectorAll('#slots-grid button').forEach(b => {
                                    b.classList.remove('border-indigo-600', 'bg-indigo-50/50');
                                    b.classList.add('border-gray-200');
                                });
                                // Set style terpilih
                                this.classList.remove('border-gray-200');
                                this.classList.add('border-indigo-600', 'bg-indigo-50/50');

                                selectedSlotId = this.dataset.id;
                                selectedSlotInput.value = selectedSlotId;

                                updateDateTimeSummary(date, slot.start_time);
                                checkFormValidity();
                            });
                        } else {
                            btn.className += 'border-gray-100 bg-gray-100 text-gray-400 cursor-not-allowed opacity-50';
                            btn.textContent = slot.start_time + ' - Penuh';
                            btn.disabled = true;
                        }

                        slotsGrid.appendChild(btn);
                    });
                } else {
                    slotsGrid.innerHTML = '<div class="col-span-full text-center py-4 text-gray-500 text-sm">Tidak ada slot operasional pada tanggal ini.</div>';
                }
            } catch (error) {
                slotsLoading.classList.add('hidden');
                slotsGrid.innerHTML = '<div class="col-span-full text-center py-4 text-red-500 text-sm"><i class="fas fa-exclamation-circle mr-2"></i>Gagal memuat slot. Silakan coba lagi.</div>';
                console.error(error);
            }
        }

        function updateDateTimeSummary(dateStr, timeStr) {
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const dateObj = new Date(dateStr);
            const formattedDate = dateObj.toLocaleDateString('id-ID', options);
            summaryDateTime.textContent = `${formattedDate} pukul ${timeStr}`;
        }

        function resetSlots() {
            slotsGrid.innerHTML = '<div class="col-span-full text-center py-4 text-gray-500 text-sm">Pilih layanan dan tanggal terlebih dahulu.</div>';
            selectedSlotInput.value = '';
            selectedSlotId = '';
            summaryDateTime.textContent = 'Belum memilih jadwal';
            checkFormValidity();
        }

        function checkFormValidity() {
            const hasService = serviceSelect.value !== '';
            const hasDate = dateInput.value !== '';
            const hasSlot = selectedSlotInput.value !== '';
            const paymentProofInput = document.getElementById('payment_proof');
            const hasPaymentProof = paymentProofInput && paymentProofInput.files && paymentProofInput.files.length > 0;

            if (hasService && hasDate && hasSlot && hasPaymentProof) {
                btnSubmit.disabled = false;
            } else {
                btnSubmit.disabled = true;
            }
        }

        // Live preview & validation untuk upload bukti pembayaran
        const paymentProofInput = document.getElementById('payment_proof');
        if (paymentProofInput) {
            paymentProofInput.addEventListener('change', function() {
                const previewContainer = document.getElementById('payment-proof-preview-container');
                const previewImg = document.getElementById('payment-proof-preview');
                
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        previewContainer.classList.remove('hidden');
                    }
                    reader.readAsDataURL(this.files[0]);
                } else {
                    previewContainer.classList.add('hidden');
                }
                checkFormValidity();
            });
        }

        // Trigger pre-select service if passed
        if (serviceSelect.value) {
            serviceSelect.dispatchEvent(new Event('change'));
        }
    });
</script>
@endpush
