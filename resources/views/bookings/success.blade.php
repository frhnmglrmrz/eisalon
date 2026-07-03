@extends('layouts.app')

@section('title', 'Reservasi Sukses - Alan\'s Art Hair Salon')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="max-w-2xl mx-auto text-center">
        <!-- Icon Sukses -->
        <div class="w-24 h-24 bg-gradient-to-br from-green-400 to-emerald-600 rounded-full flex items-center justify-center mx-auto mb-8 shadow-lg animate-bounce">
            <i class="fas fa-check text-white text-4xl"></i>
        </div>

        <h1 class="text-4xl font-bold gradient-text mb-4">Reservasi Berhasil Diajukan!</h1>
        <p class="text-gray-600 mb-8">Pemesanan Anda telah tercatat dengan status <span class="bg-amber-100 text-amber-800 px-3 py-1 rounded-full text-xs font-semibold">Pending</span>. Kami akan segera memproses reservasi Anda.</p>

        <!-- Informasi Akun Otomatis (Jika Ada) -->
        @if(session('new_user_created'))
            <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-6 mb-8 text-left shadow-sm">
                <div class="flex items-start space-x-3">
                    <div class="text-indigo-600 mt-1">
                        <i class="fas fa-user-plus text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-indigo-900 text-lg">Akun Member Anda Telah Dibuat!</h4>
                        <p class="text-indigo-700 text-sm mt-1 leading-relaxed">
                            Kami mendeteksi email Anda belum terdaftar. Untuk kemudahan Anda di masa mendatang, kami telah membuatkan akun otomatis dengan detail berikut:
                        </p>
                        <div class="mt-3 bg-white border border-indigo-100 rounded-xl p-3 inline-block">
                            <div class="text-xs text-gray-500">Email Login:</div>
                            <div class="font-semibold text-gray-800 text-sm">{{ session('new_user_created')['email'] }}</div>
                            <div class="text-xs text-gray-500 mt-2">Password Sementara:</div>
                            <div class="font-mono font-bold text-gray-800 text-sm">{{ session('new_user_created')['password'] }}</div>
                        </div>
                        <p class="text-xs text-indigo-600 mt-3">Silakan gunakan kredensial ini untuk login dan melihat riwayat pemesanan Anda.</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Rangkuman Booking -->
        <div class="glass-effect rounded-2xl p-6 shadow-md mb-8 text-left space-y-4 border border-gray-100">
            <h3 class="font-bold text-gray-800 text-lg border-b border-gray-100 pb-2">Rincian Reservasi</h3>
            
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-500 block">ID Booking:</span>
                    <span class="font-bold text-gray-800">#{{ $booking->id }}</span>
                </div>
                <div>
                    <span class="text-gray-500 block">Layanan:</span>
                    <span class="font-bold text-gray-800">{{ $booking->service->name }}</span>
                </div>
                <div>
                    <span class="text-gray-500 block">Jadwal Pertemuan:</span>
                    <span class="font-bold text-gray-800">
                        {{ \Carbon\Carbon::parse($booking->booking_date)->format('d F Y') }} <br>
                        pukul {{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }} WIB
                    </span>
                </div>
                <div>
                    <span class="text-gray-500 block">Stylist:</span>
                    <span class="font-bold text-gray-800">{{ $booking->stylist ? $booking->stylist->name : 'Pilih Siapa Saja' }}</span>
                </div>
                <div>
                    <span class="text-gray-500 block">Catatan Anda:</span>
                    <span class="font-medium text-gray-700 italic">{{ $booking->notes ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-gray-500 block">Total Biaya:</span>
                    <span class="font-bold text-indigo-900 text-base">Rp {{ number_format($booking->service->price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-center items-center">
            <a href="{{ route('home') }}" 
               class="bg-indigo-900 text-white hover:bg-indigo-950 px-8 py-3 rounded-full font-semibold shadow-md transition w-full sm:w-auto">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
