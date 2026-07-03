@extends('layouts.app')

@section('title', 'Detail Reservasi - Admin')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="mb-8 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
        <div>
            <a href="{{ route('admin.bookings.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium inline-flex items-center mb-4 transition">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Reservasi
            </a>
            <h1 class="text-4xl font-bold gradient-text">Detail Reservasi #{{ $booking->id }}</h1>
            <p class="text-gray-600 mt-1">Ubah status, pantau detail, dan kirim notifikasi pelanggan</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.bookings.index') }}" class="bg-gray-200 text-gray-700 hover:bg-gray-300 px-6 py-3 rounded-full font-semibold transition">
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Rincian Data Booking -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informasi Utama -->
            <div class="glass-effect rounded-2xl p-8 shadow-lg space-y-6">
                <h3 class="text-2xl font-bold text-gray-800 border-b border-gray-100 pb-3">Informasi Janji Temu</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                    <div>
                        <span class="text-gray-400 block uppercase font-semibold text-xs tracking-wider">Layanan</span>
                        <span class="font-bold text-gray-800 text-base mt-1 block">{{ $booking->service->name }}</span>
                        <span class="text-xs text-gray-500 mt-1 block">Kategori: {{ $booking->service->category }} | Durasi: {{ $booking->service->duration_minutes }} menit</span>
                    </div>

                    <div>
                        <span class="text-gray-400 block uppercase font-semibold text-xs tracking-wider">Stylist</span>
                        <span class="font-bold text-gray-800 text-base mt-1 block">{{ $booking->stylist ? $booking->stylist->name : 'Pilih Siapa Saja (Acak)' }}</span>
                        @if($booking->stylist)
                            <span class="text-xs text-gray-500 mt-1 block">Spesialisasi: {{ $booking->stylist->specialization }}</span>
                        @endif
                    </div>

                    <div>
                        <span class="text-gray-400 block uppercase font-semibold text-xs tracking-wider">Jadwal Pertemuan</span>
                        <span class="font-bold text-gray-800 mt-1 block">
                            {{ \Carbon\Carbon::parse($booking->booking_date)->format('d F Y') }} <br>
                            Pukul {{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }} WIB
                        </span>
                        <span class="text-xs text-gray-500 mt-1 block">Slot ID: #{{ $booking->slot_id }}</span>
                    </div>

                    <div>
                        <span class="text-gray-400 block uppercase font-semibold text-xs tracking-wider">Biaya & Pembayaran</span>
                        <span class="font-bold text-indigo-900 text-xl mt-1 block">Rp {{ number_format($booking->service->price, 0, ',', '.') }}</span>
                        <span class="text-xs text-gray-500 mt-1 block">Metode: Bayar di Tempat (Offline)</span>
                    </div>
                </div>

                @if($booking->notes)
                    <div class="border-t border-gray-100 pt-4">
                        <span class="text-gray-400 block uppercase font-semibold text-xs tracking-wider mb-1">Catatan Pelanggan</span>
                        <p class="text-gray-700 bg-gray-50/50 p-4 rounded-xl border border-gray-100 italic">"{{ $booking->notes }}"</p>
                    </div>
                @endif
            </div>

            <!-- Informasi Kontak Pelanggan -->
            <div class="glass-effect rounded-2xl p-8 shadow-lg">
                <h3 class="text-2xl font-bold text-gray-800 border-b border-gray-100 pb-3 mb-4">Profil Pelanggan</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                    <div>
                        <span class="text-gray-400 block uppercase font-semibold text-xs tracking-wider">Nama Pelanggan</span>
                        <span class="font-bold text-gray-800 text-base mt-1 block">
                            @if($booking->user)
                                {{ $booking->user->name }}
                            @else
                                {{ $booking->guest_name }} <sup class="text-xs text-indigo-600 font-semibold">Tamu</sup>
                            @endif
                        </span>
                    </div>

                    <div>
                        <span class="text-gray-400 block uppercase font-semibold text-xs tracking-wider">Nomor WhatsApp</span>
                        <span class="font-bold text-gray-800 text-base mt-1 block">
                            @if($booking->user)
                                {{ $booking->user->phone }}
                            @else
                                {{ $booking->guest_phone }}
                            @endif
                        </span>
                    </div>

                    <div>
                        <span class="text-gray-400 block uppercase font-semibold text-xs tracking-wider">Alamat Email</span>
                        <span class="font-bold text-gray-800 mt-1 block">
                            @if($booking->user)
                                {{ $booking->user->email }}
                            @else
                                {{ $booking->guest_email }}
                            @endif
                        </span>
                    </div>

                    <div>
                        <span class="text-gray-400 block uppercase font-semibold text-xs tracking-wider">Status Hubungan</span>
                        <span class="font-semibold mt-1 block">
                            @if($booking->user)
                                <span class="text-indigo-700 bg-indigo-50 border border-indigo-100 px-2.5 py-1 rounded-full text-xs">Member Terdaftar</span>
                            @else
                                <span class="text-gray-700 bg-gray-50 border border-gray-200 px-2.5 py-1 rounded-full text-xs">Pesan Sebagai Tamu</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kontrol Status -->
        <div class="lg:col-span-1 space-y-6">
            <div class="glass-effect rounded-2xl p-6 shadow-lg space-y-6">
                <h3 class="text-xl font-bold text-gray-800 border-b border-gray-100 pb-3">Kontrol Reservasi</h3>
                
                <!-- Status Saat Ini -->
                <div class="text-center p-4 bg-gray-50/50 rounded-2xl border border-gray-100">
                    <span class="text-xs text-gray-400 uppercase font-semibold block mb-1">Status Saat Ini</span>
                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                            'confirmed' => 'bg-green-100 text-green-800 border-green-200',
                            'completed' => 'bg-gray-100 text-gray-800 border-gray-200',
                            'cancelled' => 'bg-red-100 text-red-800 border-red-200'
                        ];
                        $color = $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                    @endphp
                    <span class="px-4 py-2 rounded-full text-sm font-bold border {{ $color }} inline-block">
                        {{ strtoupper($booking->status) }}
                    </span>

                    @if($booking->whatsapp_sent_at)
                        <p class="text-xs text-gray-500 mt-3">
                            <i class="fas fa-check-circle text-green-600 mr-1"></i> WA dikirim: {{ $booking->whatsapp_sent_at->format('d M H:i') }}
                        </p>
                    @endif
                </div>

                <!-- Update Status Form -->
                <div class="space-y-3">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block">Ubah Status Reservasi</span>
                    
                    <form action="{{ route('admin.bookings.updateStatus', $booking) }}" method="POST" class="space-y-3">
                        @csrf
                        @method('PATCH')
                        
                        @if($booking->status === 'pending')
                            <button type="submit" name="status" value="confirmed" 
                                    class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 px-4 rounded-xl transition text-sm flex items-center justify-center">
                                <i class="fas fa-check-circle mr-2"></i> Konfirmasi Booking
                            </button>
                            <button type="submit" name="status" value="cancelled" 
                                    class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2.5 px-4 rounded-xl transition text-sm flex items-center justify-center">
                                <i class="fas fa-times-circle mr-2"></i> Batalkan Booking
                            </button>
                        @elseif($booking->status === 'confirmed')
                            <button type="submit" name="status" value="completed" 
                                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-4 rounded-xl transition text-sm flex items-center justify-center">
                                <i class="fas fa-check-double mr-2"></i> Selesaikan Layanan
                            </button>
                            <button type="submit" name="status" value="cancelled" 
                                    class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2.5 px-4 rounded-xl transition text-sm flex items-center justify-center">
                                <i class="fas fa-times-circle mr-2"></i> Batalkan Booking
                            </button>
                        @elseif($booking->status === 'completed' || $booking->status === 'cancelled')
                            <p class="text-xs text-gray-400 italic text-center py-2">Reservasi berstatus akhir (Selesai/Batal) tidak dapat diubah kembali.</p>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
