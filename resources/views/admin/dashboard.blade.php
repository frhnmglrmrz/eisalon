@extends('layouts.app')

@section('title', 'Admin Dashboard - Alan\'s Art Hair Salon')

@section('content')
<div class="container mx-auto px-6 py-12 animate-fadeIn">
    <!-- Header -->
    <div class="mb-12">
        <h1 class="text-4xl font-bold gradient-text mb-2">Dashboard Admin</h1>
        <p class="text-gray-600">Selamat datang kembali, {{ auth()->user()->name }}! Kelola operasional salon Anda di sini.</p>
    </div>

    <!-- Ringkasan Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <!-- Total Pelanggan -->
        <div class="glass-effect rounded-2xl p-6 shadow-md border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider mb-1">Total Pelanggan</p>
                <h3 class="text-3xl font-extrabold text-indigo-900">{{ $stats['total_users'] }}</h3>
            </div>
            <div class="w-14 h-14 bg-indigo-50 border border-indigo-100 rounded-full flex items-center justify-center text-indigo-600">
                <i class="fas fa-users text-xl"></i>
            </div>
        </div>

        <!-- Total Reservasi -->
        <div class="glass-effect rounded-2xl p-6 shadow-md border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider mb-1">Total Reservasi</p>
                <h3 class="text-3xl font-extrabold text-indigo-900">{{ $stats['total_bookings'] }}</h3>
            </div>
            <div class="w-14 h-14 bg-indigo-50 border border-indigo-100 rounded-full flex items-center justify-center text-indigo-600">
                <i class="fas fa-calendar-alt text-xl"></i>
            </div>
        </div>

        <!-- Total Layanan -->
        <div class="glass-effect rounded-2xl p-6 shadow-md border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider mb-1">Total Layanan</p>
                <h3 class="text-3xl font-extrabold text-indigo-900">{{ $stats['total_services'] }}</h3>
            </div>
            <div class="w-14 h-14 bg-indigo-50 border border-indigo-100 rounded-full flex items-center justify-center text-indigo-600">
                <i class="fas fa-cut text-xl"></i>
            </div>
        </div>

        <!-- Total Pendapatan -->
        <div class="glass-effect rounded-2xl p-6 shadow-md border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider mb-1">Total Pendapatan</p>
                <h3 class="text-2xl font-extrabold text-emerald-600">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h3>
            </div>
            <div class="w-14 h-14 bg-emerald-50 border border-emerald-100 rounded-full flex items-center justify-center text-emerald-600">
                <i class="fas fa-coins text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Ringkasan Status Reservasi -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <!-- Pending -->
        <div class="glass-effect rounded-2xl p-6 shadow-md border border-yellow-100 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Menunggu Konfirmasi</h3>
                <p class="text-gray-500 text-xs mt-1">Reservasi baru yang butuh persetujuan</p>
            </div>
            <span class="bg-yellow-500 text-white px-4 py-2 rounded-xl text-lg font-extrabold shadow-sm">
                {{ $stats['pending_bookings'] }}
            </span>
        </div>

        <!-- Confirmed -->
        <div class="glass-effect rounded-2xl p-6 shadow-md border border-green-100 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Terkonfirmasi</h3>
                <p class="text-gray-500 text-xs mt-1">Jadwal salon aktif mendatang</p>
            </div>
            <span class="bg-green-500 text-white px-4 py-2 rounded-xl text-lg font-extrabold shadow-sm">
                {{ $stats['confirmed_bookings'] }}
            </span>
        </div>

        <!-- Completed -->
        <div class="glass-effect rounded-2xl p-6 shadow-md border border-gray-250 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Selesai</h3>
                <p class="text-gray-500 text-xs mt-1">Layanan yang telah dirampungkan</p>
            </div>
            <span class="bg-gray-500 text-white px-4 py-2 rounded-xl text-lg font-extrabold shadow-sm">
                {{ $stats['completed_bookings'] }}
            </span>
        </div>
    </div>

    <!-- Recent Bookings -->
    <div class="glass-effect rounded-2xl p-8 shadow-lg border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800"><i class="fas fa-history text-indigo-600 mr-2"></i>Reservasi Terbaru</h2>
            <a href="{{ route('admin.bookings.index') }}" class="text-indigo-600 hover:text-indigo-800 font-bold text-sm transition">
                Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>

        @if($recent_bookings->isEmpty())
            <div class="text-center py-12 text-gray-500">
                <i class="fas fa-calendar-times text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-400 mb-2">Belum ada reservasi masuk</h3>
                <p class="text-gray-500">Pemesanan dari pelanggan akan muncul di sini.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200 text-gray-600">
                            <th class="text-left py-4 px-4 font-semibold text-sm">Pelanggan</th>
                            <th class="text-left py-4 px-4 font-semibold text-sm">Layanan / Stylist</th>
                            <th class="text-left py-4 px-4 font-semibold text-sm">Jadwal Pertemuan</th>
                            <th class="text-left py-4 px-4 font-semibold text-sm">Status</th>
                            <th class="text-left py-4 px-4 font-semibold text-sm">Total Biaya</th>
                            <th class="text-left py-4 px-4 font-semibold text-sm">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recent_bookings as $booking)
                            <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">
                                <td class="py-4 px-4">
                                    @if($booking->user)
                                        <div class="font-bold text-gray-800">{{ $booking->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $booking->user->phone }}</div>
                                    @else
                                        <div class="font-bold text-gray-800">{{ $booking->guest_name }} <sup class="text-xs text-indigo-600">Tamu</sup></div>
                                        <div class="text-xs text-gray-500">{{ $booking->guest_phone }}</div>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <div class="font-semibold text-gray-800">{{ $booking->service->name }}</div>
                                    <div class="text-xs text-gray-500">Stylist: {{ $booking->stylist ? $booking->stylist->name : 'Acak' }}</div>
                                </td>
                                <td class="py-4 px-4 text-sm">
                                    <div class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500">Pukul: {{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }} WIB</div>
                                </td>
                                <td class="py-4 px-4 text-xs font-semibold">
                                    @php
                                        $colors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                            'confirmed' => 'bg-green-100 text-green-800 border-green-200',
                                            'completed' => 'bg-gray-100 text-gray-800 border-gray-200',
                                            'cancelled' => 'bg-red-100 text-red-800 border-red-200'
                                        ];
                                        $color = $colors[$booking->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                    @endphp
                                    <span class="px-2.5 py-1 rounded-full border {{ $color }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 font-bold text-gray-800">
                                    Rp {{ number_format($booking->service->price, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center space-x-3 text-sm font-medium">
                                        <a href="{{ route('admin.bookings.show', $booking) }}" class="text-indigo-600 hover:text-indigo-800 transition" title="Lihat detail">
                                            <i class="fas fa-eye text-lg"></i>
                                        </a>
                                    </div>
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
