@extends('layouts.app')

@section('title', 'Detail Layanan - Admin')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <a href="{{ route('admin.layanan.index') }}" class="inline-flex items-center text-sm font-semibold text-indigo-900 hover:text-indigo-950 mb-3 transition">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Layanan
            </a>
            <h1 class="text-3xl font-bold text-indigo-950 mb-2">{{ $service->name }}</h1>
            <p class="text-sm text-gray-600">Detail rincian layanan salon</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.layanan.edit', $service) }}" class="bg-yellow-600 hover:bg-yellow-750 text-white px-6 py-3 rounded-full text-sm font-semibold transition shadow-sm">
                <i class="fas fa-edit mr-2"></i>Ubah Layanan
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Info Card -->
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-200/60">
            <h2 class="text-xl font-bold text-indigo-950 mb-6 border-b border-gray-100 pb-3">Informasi Layanan</h2>
            
            <div class="space-y-4 text-sm">
                <div>
                    <label class="text-gray-500 font-light">Nama Layanan</label>
                    <p class="text-indigo-950 font-bold text-base mt-0.5">{{ $service->name }}</p>
                </div>
                
                <div>
                    <label class="text-gray-500 font-light">Deskripsi</label>
                    <p class="text-gray-700 leading-relaxed font-light mt-0.5">{{ $service->description }}</p>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-gray-500 font-light">Harga</label>
                        <p class="text-indigo-950 font-bold text-base mt-0.5">Rp {{ number_format($service->price, 0, ',', '.') }}</p>
                    </div>
                    
                    <div>
                        <label class="text-gray-500 font-light">Durasi</label>
                        <p class="text-indigo-950 font-bold text-base mt-0.5">{{ $service->duration_minutes }} menit</p>
                    </div>
                </div>
                
                <div>
                    <label class="text-gray-500 font-light">Kategori</label>
                    <div class="mt-1">
                        <span class="px-2.5 py-1 bg-indigo-50 text-indigo-900 border border-indigo-100 rounded-full text-xs font-semibold">
                            {{ $service->category }}
                        </span>
                    </div>
                </div>
                
                <div>
                    <label class="text-gray-500 font-light">Status Layanan</label>
                    <div class="mt-1">
                        @if($service->is_active)
                            <span class="px-2.5 py-1 bg-green-50 text-green-700 border border-green-200 rounded-full text-xs font-semibold">Aktif</span>
                        @else
                            <span class="px-2.5 py-1 bg-red-50 text-red-700 border border-red-200 rounded-full text-xs font-semibold">Nonaktif</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Image Card -->
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-200/60 flex flex-col items-center justify-center">
            <h2 class="text-xl font-bold text-indigo-950 mb-6 border-b border-gray-100 pb-3 w-full">Foto Layanan</h2>
            @if($service->photo)
                <img src="{{ asset('storage/' . $service->photo) }}" alt="{{ $service->name }}" class="max-h-64 object-cover rounded-2xl shadow-sm border border-gray-100">
            @else
                <div class="w-full h-64 bg-indigo-50 rounded-2xl flex items-center justify-center border border-indigo-100">
                    <i class="fas fa-cut text-indigo-900 text-5xl opacity-30"></i>
                </div>
            @endif
        </div>
    </div>

    <!-- Booking History for Service -->
    <div class="mt-8 bg-white rounded-3xl p-8 shadow-sm border border-gray-200/60">
        <h2 class="text-xl font-bold text-indigo-950 mb-6 border-b border-gray-100 pb-3">Riwayat Reservasi Terkait (10 Terbaru)</h2>
        @if($service->bookings->isEmpty())
            <p class="text-gray-500 text-sm font-light">Belum ada riwayat reservasi untuk layanan ini.</p>
        @else
            <div class="overflow-x-auto text-sm text-left">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 text-gray-500 font-semibold uppercase tracking-wider text-xs">
                            <th class="py-3 px-4">Nama Pelanggan</th>
                            <th class="py-3 px-4">Tanggal Reservasi</th>
                            <th class="py-3 px-4">Jam</th>
                            <th class="py-3 px-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($service->bookings->sortByDesc('created_at')->take(10) as $booking)
                            <tr>
                                <td class="py-3 px-4 font-medium text-indigo-950">
                                    {{ $booking->user ? $booking->user->name : $booking->guest_name . ' (Tamu)' }}
                                </td>
                                <td class="py-3 px-4 text-gray-600 font-light">
                                    {{ $booking->booking_date->format('d M Y') }}
                                </td>
                                <td class="py-3 px-4 text-gray-600 font-light">
                                    {{ date('H:i', strtotime($booking->booking_time)) }}
                                </td>
                                <td class="py-3 px-4">
                                    @if($booking->status === 'pending')
                                        <span class="px-2 py-0.5 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded text-xs font-semibold">Menunggu</span>
                                    @elseif($booking->status === 'confirmed')
                                        <span class="px-2 py-0.5 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded text-xs font-semibold">Dikonfirmasi</span>
                                    @elseif($booking->status === 'completed')
                                        <span class="px-2 py-0.5 bg-green-50 text-green-700 border border-green-200 rounded text-xs font-semibold">Selesai</span>
                                    @else
                                        <span class="px-2 py-0.5 bg-red-50 text-red-700 border border-red-200 rounded text-xs font-semibold">Batal</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
