@extends('layouts.app')

@section('title', "Galeri Portofolio - Alan's Art Hair Salon")

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-br from-indigo-950 via-indigo-900 to-indigo-950 py-16 text-white text-center">
    <div class="container mx-auto px-6">
        <h1 class="text-4xl md:text-5xl font-bold mb-4 tracking-tight">Galeri Karya Kami</h1>
        <div class="w-16 h-1 bg-white mx-auto rounded mb-4"></div>
        <p class="text-indigo-200 max-w-xl mx-auto font-light text-sm md:text-base">
            Inspirasi model potongan dan warna rambut modern hasil pengerjaan tim stylist Alan's Art Hair Salon.
        </p>
    </div>
</div>

<!-- Gallery Container -->
<div class="container mx-auto px-6 py-12">
    <!-- Filter options -->
    <div class="flex flex-wrap gap-2 justify-center mb-10">
        <a href="{{ route('gallery.index') }}" class="px-5 py-2 rounded-full text-xs font-semibold transition border {{ !$serviceId ? 'bg-indigo-900 text-white border-indigo-900 shadow-sm' : 'bg-white text-indigo-950 hover:bg-indigo-50 border-gray-200' }}">
            Semua Foto
        </a>
        @foreach($services as $service)
            @if($service->galleries()->exists())
                <a href="{{ route('gallery.index', ['service_id' => $service->id]) }}" class="px-5 py-2 rounded-full text-xs font-semibold transition border {{ $serviceId == $service->id ? 'bg-indigo-900 text-white border-indigo-900 shadow-sm' : 'bg-white text-indigo-950 hover:bg-indigo-50 border-gray-200' }}">
                    {{ $service->name }}
                </a>
            @endif
        @endforeach
    </div>

    <!-- Gallery Grid -->
    @if($galleries->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-6xl mx-auto">
            @foreach($galleries as $gallery)
                <div class="group relative aspect-square overflow-hidden rounded-2xl bg-gray-100 shadow-sm border border-gray-200/50">
                    <img src="{{ asset('storage/' . $gallery->photo) }}" alt="{{ $gallery->caption ?? 'Portofolio' }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-indigo-950/80 via-indigo-950/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 p-4 flex flex-col justify-end text-white text-xs">
                        @if($gallery->service)
                            <span class="text-[10px] uppercase text-indigo-300 font-semibold tracking-wider mb-1">{{ $gallery->service->name }}</span>
                        @endif
                        <p class="font-medium line-clamp-2">{{ $gallery->caption }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-3xl border border-gray-200 shadow-sm max-w-xl mx-auto">
            <i class="fas fa-images text-5xl text-gray-300 mb-4 animate-float"></i>
            <h3 class="text-xl font-bold text-indigo-950 mb-2">Galeri Foto Kosong</h3>
            <p class="text-sm text-gray-500 font-light max-w-xs mx-auto">Saat ini belum ada foto portofolio hasil karya stylist yang diunggah.</p>
        </div>
    @endif
</div>
@endsection
