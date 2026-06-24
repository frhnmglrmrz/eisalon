@extends('layouts.app')

@section('title', "Katalog Layanan - Alan's Art Hair Salon")

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-br from-indigo-950 via-indigo-900 to-indigo-950 py-16 text-white text-center">
    <div class="container mx-auto px-6">
        <h1 class="text-4xl md:text-5xl font-bold mb-4 tracking-tight">Katalog Layanan Kami</h1>
        <div class="w-16 h-1 bg-white mx-auto rounded mb-4"></div>
        <p class="text-indigo-200 max-w-xl mx-auto font-light text-sm md:text-base">
            Temukan layanan potongan, pewarnaan, dan perawatan rambut premium kami. Pilih yang terbaik sesuai kebutuhan gaya Anda.
        </p>
    </div>
</div>

<!-- Filter & Services Section -->
<div class="container mx-auto px-6 py-12">
    <!-- Category Badges Filter -->
    <div class="flex flex-wrap gap-2 justify-center mb-10">
        <a href="{{ route('catalog.index') }}" class="px-5 py-2 rounded-full text-sm font-semibold transition border {{ !$category ? 'bg-indigo-900 text-white border-indigo-900 shadow-sm' : 'bg-white text-indigo-950 hover:bg-indigo-50 border-gray-200' }}">
            Semua Layanan
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('catalog.index', ['category' => $cat]) }}" class="px-5 py-2 rounded-full text-sm font-semibold transition border {{ $category === $cat ? 'bg-indigo-900 text-white border-indigo-900 shadow-sm' : 'bg-white text-indigo-950 hover:bg-indigo-50 border-gray-200' }}">
                {{ $cat }}
            </a>
        @endforeach
    </div>

    <!-- Services Grouped -->
    @if($groupedServices->count() > 0)
        @foreach($groupedServices as $catName => $catServices)
            <div class="mb-16">
                <!-- Category Title -->
                <div class="flex items-center mb-8 border-b border-gray-200 pb-3">
                    <h2 class="text-2xl font-bold text-indigo-950">{{ $catName }}</h2>
                    <span class="ml-3 px-3 py-1 bg-indigo-50 text-indigo-900 border border-indigo-100 rounded-full text-xs font-semibold">
                        {{ $catServices->count() }} Pilihan
                    </span>
                </div>

                <!-- Services Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($catServices as $service)
                        <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-md transition border border-gray-200/60 flex flex-col justify-between">
                            <div>
                                <!-- Photo -->
                                <div class="relative h-48 bg-indigo-950 overflow-hidden">
                                    @if($service->photo)
                                        <img src="{{ asset('storage/' . $service->photo) }}" alt="{{ $service->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-900 to-indigo-950">
                                            <i class="fas fa-cut text-white text-4xl opacity-30"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Text -->
                                <div class="p-6">
                                    <h3 class="text-lg font-bold text-indigo-950 mb-2">{{ $service->name }}</h3>
                                    <p class="text-sm text-gray-600 font-light line-clamp-3">{{ $service->description }}</p>
                                </div>
                            </div>

                            <div class="p-6 pt-0">
                                <div class="flex items-center justify-between border-t border-gray-100 pt-4 mb-4 text-sm">
                                    <span class="text-base font-bold text-indigo-900">
                                        Rp {{ number_format($service->price, 0, ',', '.') }}
                                    </span>
                                    <span class="text-xs text-gray-500 font-light">
                                        <i class="far fa-clock mr-1"></i> {{ $service->duration_minutes }} Menit
                                    </span>
                                </div>

                                <div class="flex gap-2">
                                    <a href="{{ route('catalog.show', $service) }}" class="flex-1 text-center border border-gray-300 text-gray-700 px-4 py-2 rounded-full text-xs font-medium hover:bg-gray-50 transition">
                                        Detail Info
                                    </a>
                                    <a href="{{ route('booking.create', ['service_id' => $service->id]) }}" class="flex-1 text-center bg-indigo-900 text-white px-4 py-2 rounded-full text-xs font-medium hover:bg-indigo-950 transition">
                                        Pesan Slot
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @else
        <div class="text-center py-16 bg-white rounded-3xl border border-gray-200 shadow-sm max-w-xl mx-auto">
            <i class="fas fa-cut text-5xl text-gray-300 mb-4 animate-float"></i>
            <h3 class="text-xl font-bold text-indigo-950 mb-2">Layanan Tidak Ditemukan</h3>
            <p class="text-sm text-gray-500 font-light max-w-xs mx-auto mb-6">Maaf, saat ini belum ada layanan rambut aktif di kategori ini.</p>
            <a href="{{ route('catalog.index') }}" class="btn-primary text-white px-6 py-3 rounded-full text-sm font-semibold">
                Lihat Semua Kategori
            </a>
        </div>
    @endif
</div>
@endsection
