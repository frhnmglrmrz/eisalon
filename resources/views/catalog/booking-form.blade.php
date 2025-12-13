@extends('layouts.app')

@section('title', 'Form Pemesanan - ' . $service->name)

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="max-w-3xl mx-auto">
        <!-- Service Info Card -->
        <div class="glass-effect rounded-2xl p-8 shadow-lg mb-8">
            <div class="flex flex-col md:flex-row gap-6">
                <div class="md:w-48 h-48 bg-gradient-to-br from-pink-400 to-orange-400 rounded-xl overflow-hidden flex-shrink-0">
                    @if($service->image)
                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fas fa-spa text-white text-5xl opacity-50"></i>
                        </div>
                    @endif
                </div>
                <div class="flex-1">
                    <h1 class="text-3xl font-bold gradient-text mb-4">{{ $service->name }}</h1>
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-tag mr-3 w-5"></i>
                            <span class="font-semibold">Harga:</span>
                            <span class="ml-2 text-xl font-bold text-pink-600">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="far fa-clock mr-3 w-5"></i>
                            <span class="font-semibold">Durasi:</span>
                            <span class="ml-2">{{ $service->duration }} menit</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-layer-group mr-3 w-5"></i>
                            <span class="font-semibold">Kategori:</span>
                            <span class="ml-2 px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm">
                                {{ ucfirst(str_replace('_', ' ', $service->category)) }}
                            </span>
                        </div>
                    </div>
                    <p class="text-gray-600">{{ $service->description }}</p>
                </div>
            </div>
        </div>

        <!-- Booking Form -->
        <div class="glass-effect rounded-2xl p-8 shadow-lg">
            <h2 class="text-2xl font-bold gradient-text mb-6">
                <i class="fab fa-whatsapp mr-2 text-green-500"></i>Form Pemesanan via WhatsApp
            </h2>
            <p class="text-gray-600 mb-6">
                Isi formulir di bawah ini dan kami akan mengirimkan detail pemesanan Anda melalui WhatsApp.
            </p>

            <form action="{{ route('catalog.booking.store', $service) }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Email (Optional) -->
                <div>
                    <label for="email" class="block text-gray-700 font-bold mb-2">
                        <i class="fas fa-envelope mr-2"></i>Email (Opsional)
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email"
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none"
                        placeholder="email@example.com"
                    >
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama -->
                    <div>
                        <label for="name" class="block text-gray-700 font-bold mb-2">
                            <i class="fas fa-user mr-2"></i>Nama Lengkap *
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            required
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none"
                            placeholder="Masukkan nama lengkap"
                        >
                    </div>

                    <!-- Nomor Telepon -->
                    <div>
                        <label for="phone" class="block text-gray-700 font-bold mb-2">
                            <i class="fas fa-phone mr-2"></i>Nomor WhatsApp *
                        </label>
                        <input 
                            type="tel" 
                            id="phone" 
                            name="phone" 
                            required
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none"
                            placeholder="08xxxxxxxxxx"
                        >
                        <p class="text-xs text-gray-500 mt-1">Contoh: 081234567890</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tanggal -->
                    <div>
                        <label for="date" class="block text-gray-700 font-bold mb-2">
                            <i class="far fa-calendar mr-2"></i>Tanggal Pemesanan *
                        </label>
                        <input 
                            type="date" 
                            id="date" 
                            name="date" 
                            required
                            min="{{ date('Y-m-d') }}"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none"
                        >
                    </div>

                    <!-- Waktu -->
                    <div>
                        <label for="time" class="block text-gray-700 font-bold mb-2">
                            <i class="far fa-clock mr-2"></i>Waktu Pemesanan *
                        </label>
                        <input 
                            type="time" 
                            id="time" 
                            name="time" 
                            required
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none"
                        >
                    </div>
                </div>

                <!-- Catatan -->
                <div>
                    <label for="notes" class="block text-gray-700 font-bold mb-2">
                        <i class="fas fa-sticky-note mr-2"></i>Catatan (Opsional)
                    </label>
                    <textarea 
                        id="notes" 
                        name="notes" 
                        rows="4"
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-pink-500 focus:outline-none"
                        placeholder="Tambahkan catatan khusus jika ada..."
                    ></textarea>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button 
                        type="submit" 
                        class="w-full bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-xl font-bold text-lg transition shadow-lg hover:shadow-xl"
                    >
                        <i class="fab fa-whatsapp mr-2"></i>Kirim Pemesanan via WhatsApp
                    </button>
                    <p class="text-center text-sm text-gray-500 mt-4">
                        Dengan mengirim formulir ini, Anda akan diarahkan ke WhatsApp untuk menyelesaikan pemesanan.
                    </p>
                </div>
            </form>
        </div>

        <!-- Back Button -->
        <div class="mt-6 text-center">
            <a href="{{ route('catalog.index') }}" class="text-gray-600 hover:text-pink-600 transition">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Katalog
            </a>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="fixed top-20 right-6 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg z-50 animate-fadeIn">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@endsection

