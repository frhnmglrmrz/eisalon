@extends('layouts.app')

@section('title', 'Detail Stylist - Admin')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="mb-8 flex flex-col md:flex-row md:justify-between md:items-center">
        <div>
            <a href="{{ route('admin.stylist.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium inline-flex items-center mb-4 transition">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Stylist
            </a>
            <h1 class="text-4xl font-bold gradient-text">{{ $stylist->name }}</h1>
            <p class="text-gray-600 mt-1">Detail profil dan jadwal booking stylist</p>
        </div>
        <div class="flex space-x-2 mt-4 md:mt-0">
            <a href="{{ route('admin.stylist.edit', $stylist) }}" class="btn-primary text-white px-6 py-3 rounded-full font-semibold shadow-md">
                <i class="fas fa-edit mr-2"></i>Ubah Data
            </a>
            <a href="{{ route('admin.stylist.index') }}" class="bg-gray-200 text-gray-700 hover:bg-gray-300 px-6 py-3 rounded-full font-semibold transition">
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Kolom Kiri: Info Stylist -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Foto Profil -->
            <div class="glass-effect rounded-2xl p-6 shadow-lg text-center">
                <div class="mb-4">
                    @if($stylist->photo)
                        <img src="{{ asset('storage/' . $stylist->photo) }}" alt="{{ $stylist->name }}" class="w-48 h-48 mx-auto object-cover rounded-full shadow-md border-4 border-white">
                    @else
                        <div class="w-48 h-48 mx-auto bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center shadow-md">
                            <i class="fas fa-user text-white text-6xl"></i>
                        </div>
                    @endif
                </div>
                <h3 class="text-2xl font-bold text-gray-800">{{ $stylist->name }}</h3>
                <p class="text-gray-500 text-sm mt-1">ID Stylist: #{{ $stylist->id }}</p>
                <div class="mt-4">
                    @if($stylist->is_available)
                        <span class="px-4 py-1.5 bg-green-100 text-green-700 rounded-full text-sm font-semibold inline-block">
                            <i class="fas fa-check-circle mr-1.5"></i>Tersedia
                        </span>
                    @else
                        <span class="px-4 py-1.5 bg-red-100 text-red-700 rounded-full text-sm font-semibold inline-block">
                            <i class="fas fa-times-circle mr-1.5"></i>Tidak Tersedia
                        </span>
                    @endif
                </div>
            </div>

            <!-- Detail Kontak & Spesialisasi -->
            <div class="glass-effect rounded-2xl p-6 shadow-lg">
                <h2 class="text-xl font-bold text-gray-800 border-b border-gray-100 pb-3 mb-4">Informasi Profil</h2>
                <div class="space-y-4">
                    <div>
                        <label class="text-gray-500 text-xs font-semibold uppercase tracking-wider block">Spesialisasi</label>
                        <div class="mt-1">
                            @if($stylist->specialization)
                                <span class="px-3 py-1 bg-indigo-50 text-indigo-700 border border-indigo-100 rounded-full text-xs font-semibold inline-block">
                                    {{ $stylist->specialization }}
                                </span>
                            @else
                                <span class="text-gray-400 text-sm">Umum</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <label class="text-gray-500 text-xs font-semibold uppercase tracking-wider block">Bio</label>
                        <p class="text-gray-700 mt-1 leading-relaxed text-sm whitespace-pre-line">{{ $stylist->bio ?? 'Belum ada deskripsi bio.' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Jadwal/Booking Terkait -->
        <div class="lg:col-span-2">
            <div class="glass-effect rounded-2xl p-6 shadow-lg h-full">
                <h2 class="text-2xl font-bold text-gray-800 border-b border-gray-100 pb-3 mb-6">
                    <i class="fas fa-calendar-check text-indigo-600 mr-2"></i>Daftar Booking Stylist
                </h2>

                @if($stylist->bookings->isEmpty())
                    <div class="text-center py-12 text-gray-500">
                        <div class="w-16 h-16 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-3">
                            <i class="fas fa-calendar-times text-3xl text-gray-300"></i>
                        </div>
                        <h3 class="font-bold text-gray-700 mb-1">Belum ada booking</h3>
                        <p class="text-sm">Stylist ini belum memiliki pesanan jadwal atau histori booking.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-200 text-gray-600">
                                    <th class="text-left py-3 px-3 font-semibold">Pelanggan</th>
                                    <th class="text-left py-3 px-3 font-semibold">Layanan</th>
                                    <th class="text-left py-3 px-3 font-semibold">Tanggal & Waktu</th>
                                    <th class="text-left py-3 px-3 font-semibold">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stylist->bookings as $booking)
                                    <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">
                                        <td class="py-3 px-3">
                                            @if($booking->user)
                                                <div class="font-bold text-gray-800">{{ $booking->user->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $booking->user->email }}</div>
                                            @else
                                                <div class="font-bold text-gray-800">{{ $booking->guest_name }} <sup class="text-xs text-indigo-600">Tamu</sup></div>
                                                <div class="text-xs text-gray-500">{{ $booking->guest_phone }}</div>
                                            @endif
                                        </td>
                                        <td class="py-3 px-3">
                                            <div class="font-semibold text-gray-800">{{ $booking->service->name }}</div>
                                            <div class="text-xs text-gray-500">Durasi: {{ $booking->service->duration_minutes }} menit</div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <div class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</div>
                                            <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}</div>
                                        </td>
                                        <td class="py-3 px-3">
                                            @php
                                                $statusColors = [
                                                    'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                    'confirmed' => 'bg-green-100 text-green-800 border-green-200',
                                                    'completed' => 'bg-gray-100 text-gray-800 border-gray-200',
                                                    'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                                                ];
                                                $color = $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                            @endphp
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $color }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
