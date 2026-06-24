@extends('layouts.app')

@section('title', "Alan's Art Hair Salon - Premium Haircuts & Styling")

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-br from-indigo-950 via-indigo-900 to-indigo-950 py-24 md:py-36 text-white">
    <div class="container mx-auto px-6 text-center z-10 relative">
        <div class="max-w-4xl mx-auto animate-fadeIn">
            <span class="bg-indigo-800 text-indigo-200 px-4 py-2 rounded-full text-xs font-semibold tracking-wider uppercase mb-6 inline-block">UMKM Hair Salon Premium</span>
            <h1 class="text-5xl md:text-7xl font-bold mb-6 tracking-tight leading-none text-white">
                Alan's Art Hair Salon
            </h1>
            <p class="text-lg md:text-xl text-indigo-200 mb-10 max-w-2xl mx-auto font-light leading-relaxed">
                Sentuhan seni profesional untuk rambut Anda. Kami menghadirkan potongan rambut tren masa kini, pewarnaan premium, dan perawatan rambut terbaik untuk menunjang penampilan Anda.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('booking.create') }}" class="bg-white text-indigo-950 px-8 py-4 rounded-full font-bold text-lg hover:bg-indigo-50 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <i class="far fa-calendar-check mr-2"></i>Pesan Sekarang
                </a>
                <a href="{{ route('catalog.index') }}" class="border border-indigo-300 text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-white/10 transition">
                    <i class="fas fa-cut mr-2"></i>Lihat Layanan
                </a>
            </div>
        </div>
    </div>
    
    <!-- Floating background elements -->
    <div class="absolute top-20 left-10 w-24 h-24 bg-indigo-500 rounded-full opacity-10 animate-float"></div>
    <div class="absolute bottom-20 right-10 w-36 h-36 bg-indigo-600 rounded-full opacity-10 animate-float" style="animation-delay: 1.5s;"></div>
</section>

<!-- About Section -->
<section id="about" class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-12 items-center">
            <div class="relative animate-fadeIn">
                <div class="absolute inset-0 bg-indigo-900 rounded-3xl transform rotate-3 scale-95 opacity-5"></div>
                <div class="relative bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-3xl p-8 shadow-sm border border-indigo-100">
                    <h3 class="text-3xl font-bold text-indigo-950 mb-4">Profil Salon Kami</h3>
                    <p class="text-gray-700 mb-4 leading-relaxed font-light">
                        Di **Alan's Art Hair Salon**, kami percaya bahwa rambut adalah mahkota Anda. Setiap helai rambut yang kami sentuh adalah wujud dari seni potongan, detail pewarnaan, dan perawatan berkualitas tinggi.
                    </p>
                    <p class="text-gray-700 leading-relaxed font-light">
                        Dipimpin oleh stylist berpengalaman dan didukung produk premium, kami menjamin setiap kunjungan Anda mendatangkan kepuasan maksimal dan rasa percaya diri baru.
                    </p>
                    <div class="grid grid-cols-2 gap-4 mt-8">
                        <div class="flex items-center text-indigo-900">
                            <i class="fas fa-check-circle text-indigo-600 mr-2"></i>
                            <span class="font-medium text-sm">Stylist Berbakat</span>
                        </div>
                        <div class="flex items-center text-indigo-900">
                            <i class="fas fa-check-circle text-indigo-600 mr-2"></i>
                            <span class="font-medium text-sm">Produk Premium</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="space-y-6">
                <h2 class="text-4xl font-bold text-indigo-950">Mengapa Memilih Kami?</h2>
                <div class="w-16 h-1 bg-indigo-900 rounded"></div>
                
                <div class="flex gap-4">
                    <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-900 shrink-0 shadow-sm border border-indigo-100">
                        <i class="fas fa-magic"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-indigo-950 mb-1">Hasil Stylist Profesional</h4>
                        <p class="text-sm text-gray-600 font-light">Setiap stylist kami memiliki kualifikasi tinggi di bidang pemotongan pria, wanita, pewarnaan, dan hair care.</p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-900 shrink-0 shadow-sm border border-indigo-100">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-indigo-950 mb-1">Reservasi Online Praktis</h4>
                        <p class="text-sm text-gray-600 font-light">Pilih layanan, stylist favorit, tanggal, dan jam kosong secara instan tanpa perlu antre di tempat.</p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-900 shrink-0 shadow-sm border border-indigo-100">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-indigo-950 mb-1">Konfirmasi WhatsApp Cepat</h4>
                        <p class="text-sm text-gray-600 font-light">Selesai booking, format rincian pemesanan disiapkan otomatis untuk dikirim ke WhatsApp Admin sebagai validasi cepat.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Services Section -->
<section class="py-20 bg-gray-50 border-t border-b border-gray-200/50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-indigo-950 mb-4">Layanan Unggulan Kami</h2>
            <div class="w-20 h-1 bg-indigo-900 mx-auto rounded"></div>
            <p class="text-gray-600 mt-4 font-light max-w-xl mx-auto">Jelajahi berbagai perawatan rambut terbaik yang kami sediakan untuk Anda.</p>
        </div>
        
        @if($featuredServices->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto mb-12">
                @foreach($featuredServices as $index => $service)
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-md transition border border-gray-200/60 flex flex-col justify-between">
                        <div>
                            <!-- Service Photo -->
                            <div class="relative h-56 bg-indigo-950 overflow-hidden">
                                @if($service->photo)
                                    <img src="{{ asset('storage/' . $service->photo) }}" alt="{{ $service->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-900 to-indigo-950">
                                        <i class="fas fa-cut text-white text-5xl opacity-40"></i>
                                    </div>
                                @endif
                                <div class="absolute top-4 left-4">
                                    <span class="bg-white/95 text-indigo-950 px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider">
                                        {{ $service->category }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Info -->
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-indigo-950 mb-2">{{ $service->name }}</h3>
                                <p class="text-sm text-gray-500 font-light line-clamp-3 mb-4">{{ $service->description }}</p>
                            </div>
                        </div>

                        <div class="p-6 pt-0">
                            <div class="flex items-center justify-between border-t border-gray-100 pt-4 mb-4">
                                <span class="text-lg font-bold text-indigo-900">
                                    Rp {{ number_format($service->price, 0, ',', '.') }}
                                </span>
                                <span class="text-xs text-gray-500">
                                    <i class="far fa-clock mr-1"></i> {{ $service->duration_minutes }} Menit
                                </span>
                            </div>
                            
                            <div class="flex gap-2">
                                <a href="{{ route('catalog.show', $service) }}" class="flex-1 text-center border border-gray-300 text-gray-700 px-4 py-2.5 rounded-full text-sm font-medium hover:bg-gray-50 transition">
                                    Detail
                                </a>
                                <a href="{{ route('booking.create', ['service_id' => $service->id]) }}" class="flex-1 text-center bg-indigo-900 text-white px-4 py-2.5 rounded-full text-sm font-medium hover:bg-indigo-950 transition">
                                    Pesan
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="text-center">
                <a href="{{ route('catalog.index') }}" class="inline-block bg-white border border-gray-300 text-gray-700 px-8 py-3.5 rounded-full font-semibold hover:bg-gray-50 transition shadow-sm">
                    Lihat Semua Layanan <i class="fas fa-arrow-right ml-2 text-indigo-600"></i>
                </a>
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-cut text-5xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">Layanan belum tersedia.</p>
            </div>
        @endif
    </div>
</section>

<!-- Gallery Section -->
@if(isset($latestGalleries) && $latestGalleries->count() > 0)
<section class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-indigo-950 mb-4">Galeri Portofolio</h2>
            <div class="w-20 h-1 bg-indigo-900 mx-auto rounded"></div>
            <p class="text-gray-600 mt-4 font-light max-w-xl mx-auto">Inspirasi model rambut dan pengerjaan seni terbaik di salon kami.</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-6xl mx-auto mb-12">
            @foreach($latestGalleries as $gallery)
                <div class="group relative aspect-square overflow-hidden rounded-2xl bg-gray-100 shadow-sm border border-gray-100">
                    <img src="{{ asset('storage/' . $gallery->photo) }}" alt="{{ $gallery->caption ?? 'Portofolio' }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                    @if($gallery->caption || $gallery->service)
                        <div class="absolute inset-0 bg-gradient-to-t from-indigo-950/80 via-indigo-950/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 p-4 flex flex-col justify-end text-white">
                            @if($gallery->service)
                                <span class="text-xs uppercase text-indigo-300 font-semibold tracking-wider mb-1">{{ $gallery->service->name }}</span>
                            @endif
                            <p class="text-sm font-medium line-clamp-2">{{ $gallery->caption }}</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        
        <div class="text-center">
            <a href="{{ route('gallery.index') }}" class="inline-block bg-white border border-gray-300 text-gray-700 px-8 py-3.5 rounded-full font-semibold hover:bg-gray-50 transition shadow-sm">
                Buka Galeri Foto <i class="fas fa-images ml-2 text-indigo-600"></i>
            </a>
        </div>
    </div>
</section>
@endif

<!-- Info & Hours Section -->
<section id="contact" class="py-20 bg-gradient-to-br from-indigo-50 via-white to-indigo-100 border-t border-gray-200/50">
    <div class="container mx-auto px-6">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-indigo-950 mb-4">Informasi Salon</h2>
                <div class="w-20 h-1 bg-indigo-900 mx-auto rounded"></div>
            </div>
            
            <div class="grid md:grid-cols-2 gap-8 mb-12">
                <!-- Kontak -->
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-indigo-100/50 flex items-start gap-4">
                    <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-900 shrink-0">
                        <i class="fas fa-map-marker-alt text-xl"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-indigo-950 mb-1">Lokasi Kami</h4>
                        <p class="text-sm text-gray-600 font-light">Batam, Indonesia</p>
                        <p class="text-xs text-gray-500 mt-2">Dapatkan gaya rambut impian Anda dengan mengunjungi lokasi fisik kami yang nyaman.</p>
                    </div>
                </div>

                <!-- Jam Operasional -->
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-indigo-100/50 flex items-start gap-4">
                    <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-900 shrink-0">
                        <i class="far fa-clock text-xl"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-indigo-950 mb-1">Jam Kerja</h4>
                        <p class="text-sm text-gray-600 font-light">Senin - Minggu: 09:00 - 17:00</p>
                        <p class="text-xs text-gray-500 mt-2">Reservasi online dapat dilakukan kapan saja. Slot janji temu tersedia dalam batas jam tersebut.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
