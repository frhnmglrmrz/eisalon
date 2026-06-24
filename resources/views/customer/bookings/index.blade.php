@extends('layouts.app')

@section('title', 'Reservasi Saya - Alan\'s Art Hair Salon')

@section('content')
<div class="container mx-auto px-6 py-12 animate-fadeIn">
    <div class="mb-8">
        <h1 class="text-4xl font-bold gradient-text mb-2">Reservasi Saya</h1>
        <p class="text-gray-600">Pantau dan kelola jadwal pertemuan salon Anda</p>
    </div>

    @if($bookings->isEmpty())
        <div class="glass-effect rounded-2xl p-12 text-center shadow-lg border border-gray-100">
            <div class="w-20 h-20 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-calendar-times text-4xl text-gray-400"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-700 mb-2">Belum ada reservasi</h3>
            <p class="text-gray-500 mb-6">Anda belum memiliki riwayat reservasi jadwal pertemuan.</p>
            <a href="{{ route('booking.create') }}" class="btn-primary text-white px-8 py-3 rounded-full font-semibold shadow-md inline-block">
                <i class="fas fa-calendar-plus mr-2"></i>Buat Reservasi Sekarang
            </a>
        </div>
    @else
        <div class="space-y-6">
            @foreach($bookings as $index => $booking)
                <div class="glass-effect rounded-2xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100">
                    <div class="md:flex">
                        <!-- Detail Rangkuman Kiri -->
                        <div class="md:w-64 bg-gradient-to-br from-indigo-900 to-indigo-950 p-6 flex flex-col justify-between text-white relative">
                            <div>
                                <span class="text-xs text-indigo-200 uppercase font-bold tracking-wider">ID Booking</span>
                                <h4 class="text-2xl font-bold mt-1">#{{ $booking->id }}</h4>
                            </div>
                            
                            <!-- Status Badge -->
                            <div class="mt-4 md:mt-0">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                        'confirmed' => 'bg-green-100 text-green-800 border-green-200',
                                        'completed' => 'bg-gray-100 text-gray-800 border-gray-200',
                                        'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                                    ];
                                    $statusLabels = [
                                        'pending' => 'Menunggu Konfirmasi',
                                        'confirmed' => 'Terkonfirmasi',
                                        'completed' => 'Selesai',
                                        'cancelled' => 'Dibatalkan',
                                    ];
                                    $color = $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800';
                                    $label = $statusLabels[$booking->status] ?? $booking->status;
                                @endphp
                                <span class="px-3.5 py-1.5 rounded-full text-xs font-semibold border {{ $color }} inline-block">
                                    {{ $label }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Rincian Kanan -->
                        <div class="flex-1 p-6 flex flex-col justify-between">
                            <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-800 mb-3">{{ $booking->service->name }}</h3>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2 text-sm text-gray-600">
                                        <div class="flex items-center">
                                            <i class="far fa-calendar-alt w-5 text-indigo-600"></i>
                                            <span>{{ \Carbon\Carbon::parse($booking->booking_date)->format('l, d F Y') }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="far fa-clock w-5 text-indigo-600"></i>
                                            <span>{{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }} WIB</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-user-friends w-5 text-indigo-600"></i>
                                            <span>Stylist: {{ $booking->stylist ? $booking->stylist->name : 'Pilih Siapa Saja' }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="far fa-hourglass w-5 text-indigo-600"></i>
                                            <span>Durasi: {{ $booking->service->duration_minutes }} Menit</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="md:text-right">
                                    <div class="text-xs text-gray-400">Total Harga</div>
                                    <div class="text-3xl font-bold text-indigo-900 mt-1">
                                        Rp {{ number_format($booking->service->price, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>

                            @if($booking->notes)
                                <div class="bg-gray-50/50 rounded-xl p-4 mt-4 border border-gray-100 text-sm">
                                    <span class="text-gray-500 font-semibold block mb-1">Catatan Tambahan:</span>
                                    <p class="text-gray-700 italic">"{{ $booking->notes }}"</p>
                                </div>
                            @endif

                            <!-- Aksi -->
                            <div class="flex flex-wrap gap-3 mt-6 pt-4 border-t border-gray-100">
                                @if($booking->status === 'pending')
                                    @php
                                        // Cari admin untuk nomor telepon WhatsApp
                                        $admin = \App\Models\User::where('role', 'admin')->first();
                                        $adminPhone = $admin ? $admin->phone : '6289523808660';
                                        
                                        // Bersihkan format nomor telepon agar diawali kode negara
                                        $adminPhone = preg_replace('/[^0-9]/', '', $adminPhone);
                                        if (str_starts_with($adminPhone, '0')) {
                                            $adminPhone = '62' . substr($adminPhone, 1);
                                        }

                                        $customerName = Auth::user()->name;
                                        $dateFormatted = \Carbon\Carbon::parse($booking->booking_date)->format('d F Y');
                                        $timeFormatted = \Carbon\Carbon::parse($booking->booking_time)->format('H:i');
                                        $stylistName = $booking->stylist ? $booking->stylist->name : 'Pilih Siapa Saja';

                                        $message = "Halo Admin Alan's Art Hair Salon,\n\n" .
                                                   "Saya ingin mengonfirmasi pemesanan reservasi saya:\n" .
                                                   "- **ID Booking**: #{$booking->id}\n" .
                                                   "- **Nama**: {$customerName}\n" .
                                                   "- **Layanan**: {$booking->service->name}\n" .
                                                   "- **Stylist**: {$stylistName}\n" .
                                                   "- **Jadwal**: {$dateFormatted} jam {$timeFormatted}\n" .
                                                   "- **Total**: Rp " . number_format($booking->service->price, 0, ',', '.') . "\n\n" .
                                                   "Mohon untuk mengonfirmasi jadwal pemesanan saya. Terima kasih!";

                                        $whatsappUrl = "https://wa.me/{$adminPhone}?text=" . urlencode($message);
                                    @endphp
                                    <a href="{{ $whatsappUrl }}" target="_blank" 
                                       class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-full font-semibold text-sm shadow-sm transition flex items-center">
                                        <i class="fab fa-whatsapp mr-2 text-base"></i>Konfirmasi via WA
                                    </a>
                                @endif

                                @if($booking->canBeCancelled())
                                    <form action="{{ route('customer.bookings.cancel', $booking) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?');">
                                        @csrf
                                        <button type="submit" 
                                                class="px-5 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-full font-semibold text-sm shadow-sm transition flex items-center">
                                            <i class="fas fa-times mr-2"></i>Batalkan Pertemuan
                                        </button>
                                    </form>
                                @else
                                    @if(in_array($booking->status, ['pending', 'confirmed']))
                                        <span class="text-gray-400 text-xs self-center flex items-center" title="Pembatalan hanya diperbolehkan minimal 24 jam sebelum jadwal.">
                                            <i class="fas fa-info-circle mr-1"></i>Pembatalan ditutup (kurang dari 24 jam)
                                        </span>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $bookings->links() }}
        </div>
    @endif
</div>
@endsection
