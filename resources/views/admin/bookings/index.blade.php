@extends('layouts.app')

@section('title', 'Kelola Reservasi - Admin')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="mb-8">
        <h1 class="text-4xl font-bold gradient-text mb-2">Kelola Reservasi</h1>
        <p class="text-gray-600">Pantau dan kelola jadwal janji temu pelanggan salon</p>
    </div>

    <!-- Filter & Pencarian -->
    <div class="glass-effect rounded-2xl p-6 shadow-lg mb-8">
        <form method="GET" action="{{ route('admin.bookings.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label for="search" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Pencarian</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Cari nama, no. WA, ID..." 
                       class="w-full px-4 py-2.5 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:outline-none transition text-sm">
            </div>

            <div>
                <label for="status" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Status</label>
                <select id="status" name="status" class="w-full px-4 py-2.5 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:outline-none transition text-sm">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div>
                <label for="date" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Tanggal Pertemuan</label>
                <input type="date" id="date" name="date" value="{{ request('date') }}" 
                       class="w-full px-4 py-2.5 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:outline-none transition text-sm">
            </div>

            <div class="flex space-x-2">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl font-semibold transition text-sm shadow-sm flex-1">
                    Cari & Filter
                </button>
                @if(request()->anyFilled(['search', 'status', 'date']))
                    <a href="{{ route('admin.bookings.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2.5 rounded-xl font-semibold transition text-sm text-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabel Data Reservasi -->
    <div class="glass-effect rounded-2xl p-6 shadow-lg">
        @if($bookings->isEmpty())
            <div class="text-center py-12 text-gray-500">
                <div class="w-20 h-20 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-calendar-times text-4xl text-gray-400"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-700 mb-2">Tidak ada data reservasi</h3>
                <p class="text-gray-500">Hasil pencarian kosong atau belum ada booking masuk.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200 text-gray-600">
                            <th class="text-left py-4 px-4 font-semibold text-sm">ID</th>
                            <th class="text-left py-4 px-4 font-semibold text-sm">Pelanggan</th>
                            <th class="text-left py-4 px-4 font-semibold text-sm">Layanan</th>
                            <th class="text-left py-4 px-4 font-semibold text-sm">Jadwal Pertemuan</th>
                            <th class="text-left py-4 px-4 font-semibold text-sm">Status</th>
                            <th class="text-left py-4 px-4 font-semibold text-sm">Biaya</th>
                            <th class="text-left py-4 px-4 font-semibold text-sm">Notifikasi</th>
                            <th class="text-left py-4 px-4 font-semibold text-sm">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                            <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">
                                <td class="py-4 px-4 font-bold text-indigo-900">
                                    #{{ $booking->id }}
                                </td>
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
                                <td class="py-4 px-4 text-xs">
                                    @if($booking->whatsapp_sent_at)
                                        <span class="text-green-600 flex items-center" title="Dikirim pada {{ $booking->whatsapp_sent_at->format('d M Y H:i') }}">
                                            <i class="fas fa-check-circle mr-1"></i> Terkirim
                                        </span>
                                    @else
                                        <span class="text-gray-400">Belum Dikirim</span>
                                    @endif
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
            <div class="mt-6">
                {{ $bookings->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
