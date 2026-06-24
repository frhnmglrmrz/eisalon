<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\StylistController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerBookingController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\Admin\AdminStylistController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminSlotController;
use App\Http\Controllers\Admin\AdminGalleryController;

// ── Landing & Catalog ──────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/layanan', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/layanan/{service}', [CatalogController::class, 'show'])->name('catalog.show');
Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery.index');

// ── Booking Tamu (tanpa login) ─────────────────────────────
Route::get('/reservasi', [BookingController::class, 'create'])->name('booking.create');
Route::post('/reservasi', [BookingController::class, 'store'])->name('booking.store');
Route::get('/reservasi/sukses/{booking}', [BookingController::class, 'success'])->name('booking.success');

// ── Cek Slot Availability (AJAX/JSON) ─────────────────────
Route::get('/api/slots', [SlotController::class, 'available'])->name('slots.available');
Route::get('/api/stylists', [StylistController::class, 'available'])->name('stylists.available');

// ── Auth ───────────────────────────────────────────────────
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── Area Pelanggan (perlu login) ───────────────────────────
Route::middleware('auth')->prefix('akun')->name('customer.')->group(function () {
    Route::get('/reservasi-saya', [CustomerBookingController::class, 'index'])->name('bookings.index');
    Route::post('/reservasi/{booking}/batal', [CustomerBookingController::class, 'cancel'])->name('bookings.cancel');
});

// ── Admin ──────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Layanan
    Route::resource('layanan', AdminServiceController::class);

    // Stylist
    Route::resource('stylist', AdminStylistController::class);

    // Booking
    Route::get('/reservasi', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/reservasi/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::patch('/reservasi/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.updateStatus');
    Route::get('/reservasi/{booking}/whatsapp', [AdminBookingController::class, 'generateWhatsapp'])->name('bookings.whatsapp');

    // Slot Jadwal
    Route::resource('slot', AdminSlotController::class);

    // Galeri
    Route::resource('galeri', AdminGalleryController::class);
});

// ── Database Check (for testing only) ─────────────────────
Route::get('/check-database', function() {
    $data = [
        'status' => 'Database is working! ✅',
        'database_path' => database_path('database.sqlite'),
        'database_exists' => file_exists(database_path('database.sqlite')),
        'data_counts' => [
            'services' => \App\Models\Service::count(),
            'users' => \App\Models\User::count(),
            'stylists' => \App\Models\Stylist::count(),
            'slots' => \App\Models\Slot::count(),
            'bookings' => \App\Models\Booking::count(),
            'galleries' => \App\Models\Gallery::count(),
        ],
    ];
    return response()->json($data, 200, [], JSON_PRETTY_PRINT);
});
