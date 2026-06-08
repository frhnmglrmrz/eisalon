@extends('layouts.app')

@section('title', 'Pemesanan Berhasil - ' . config('app.name'))

@section('content')
<div class="pt-24 pb-16 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-6 max-w-2xl">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden p-8 text-center">
            
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-check text-4xl text-green-500"></i>
            </div>

            <h1 class="text-3xl font-bold text-gray-800 mb-4">Pemesanan Berhasil!</h1>
            <p class="text-gray-600 mb-8">
                Terima kasih, <strong>{{ $booking->user->name }}</strong>. Pesanan Anda untuk layanan <strong>{{ $booking->service->name }}</strong> pada tanggal <strong>{{ \Carbon\Carbon::parse($booking->booking_date)->locale('id')->isoFormat('dddd, D MMMM YYYY [pukul] H:mm') }}</strong> telah berhasil disimpan.
            </p>

            <div class="bg-gray-50 rounded-xl p-6 mb-8 text-left">
                <h2 class="font-bold text-gray-800 mb-4 border-b pb-2">Detail Pesanan</h2>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">ID Booking</span>
                    <span class="font-medium">#{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Layanan</span>
                    <span class="font-medium">{{ $booking->service->name }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Total Biaya</span>
                    <span class="font-medium text-pink-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Status</span>
                    <span class="font-medium text-yellow-600">Menunggu Pembayaran</span>
                </div>
            </div>

            @php
                $waMessage = "Halo Ei Salon, saya telah melakukan booking via website.\n\n"
                    . "*ID Booking:* #" . str_pad($booking->id, 5, '0', STR_PAD_LEFT) . "\n"
                    . "*Nama:* " . $booking->user->name . "\n"
                    . "*Layanan:* " . $booking->service->name . "\n"
                    . "*Jadwal:* " . \Carbon\Carbon::parse($booking->booking_date)->locale('id')->isoFormat('dddd, D MMMM YYYY [pukul] H:mm') . "\n"
                    . "*Total Biaya:* Rp " . number_format($booking->total_price, 0, ',', '.') . "\n\n"
                    . "Mohon instruksi pembayaran selanjutnya. Terima kasih!";
                $encodedMessage = urlencode($waMessage);
                $waLink = "https://wa.me/{$whatsappNumber}?text={$encodedMessage}";
            @endphp

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('catalog.booking.receipt', $booking->id) }}" class="btn-primary w-full sm:w-auto px-6 py-3 rounded-xl flex items-center justify-center gap-2">
                    <i class="fas fa-file-pdf"></i> Download Struk PDF
                </a>
                
                <a href="{{ $waLink }}" target="_blank" class="bg-green-500 hover:bg-green-600 text-white w-full sm:w-auto px-6 py-3 rounded-xl transition-all duration-300 font-bold flex items-center justify-center gap-2">
                    <i class="fab fa-whatsapp text-xl"></i> Konfirmasi via WhatsApp
                </a>
            </div>

            <p class="text-sm text-gray-500 mt-6">
                Mohon segera lakukan konfirmasi via WhatsApp agar jadwal Anda dapat diproses lebih lanjut.
            </p>
        </div>
    </div>
</div>
@endsection
