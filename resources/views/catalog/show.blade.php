@extends('layouts.app')

@section('title', $service->name . " - Alan's Art Hair Salon")

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="max-w-4xl mx-auto">
        <!-- Back link -->
        <a href="{{ route('catalog.index') }}" class="inline-flex items-center text-sm font-semibold text-indigo-900 hover:text-indigo-950 mb-6 transition">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Katalog Layanan
        </a>

        <!-- Service Detail Card -->
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-200/60 mb-10">
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Photo/Cover -->
                <div class="md:w-72 aspect-square rounded-2xl overflow-hidden bg-indigo-950 shrink-0 shadow-inner">
                    @if($service->photo)
                        <img src="{{ asset('storage/' . $service->photo) }}" alt="{{ $service->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-900 to-indigo-950">
                            <i class="fas fa-cut text-white text-6xl opacity-30"></i>
                        </div>
                    @endif
                </div>

                <!-- Info Detail -->
                <div class="flex-1 flex flex-col justify-between">
                    <div>
                        <span class="bg-indigo-50 text-indigo-900 border border-indigo-100 px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider mb-3 inline-block">
                            {{ $service->category }}
                        </span>
                        <h1 class="text-3xl font-bold text-indigo-950 mb-4">{{ $service->name }}</h1>
                        
                        <div class="grid grid-cols-2 gap-4 mb-6 py-4 border-t border-b border-gray-100 text-sm">
                            <div>
                                <p class="text-xs text-gray-500 font-light">Estimasi Waktu</p>
                                <p class="font-semibold text-indigo-950 mt-0.5">
                                    <i class="far fa-clock mr-1 text-indigo-600"></i> {{ $service->duration_minutes }} Menit
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-light">Harga Layanan</p>
                                <p class="font-bold text-lg text-indigo-900 mt-0.5">
                                    Rp {{ number_format($service->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        <p class="text-gray-600 font-light leading-relaxed">{{ $service->description }}</p>
                    </div>

                    <div class="mt-8 pt-4">
                        <a href="{{ route('booking.create', ['service_id' => $service->id]) }}" class="inline-block bg-indigo-900 text-white px-8 py-3.5 rounded-full font-semibold hover:bg-indigo-950 transition shadow-sm">
                            <i class="far fa-calendar-check mr-2"></i>Pesan Jadwal Layanan
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Gallery Photos -->
        @if($service->galleries->count() > 0)
            <div>
                <h3 class="text-2xl font-bold text-indigo-950 mb-6">Hasil Portofolio Layanan Ini</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($service->galleries as $gallery)
                        <div class="group relative aspect-square overflow-hidden rounded-2xl bg-gray-100 shadow-sm border border-gray-200/50">
                            <img src="{{ asset('storage/' . $gallery->photo) }}" alt="{{ $gallery->caption ?? 'Portofolio' }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                            @if($gallery->caption)
                                <div class="absolute inset-0 bg-gradient-to-t from-indigo-950/80 via-indigo-950/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 p-4 flex flex-col justify-end text-white text-xs">
                                    <p class="font-medium line-clamp-2">{{ $gallery->caption }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
