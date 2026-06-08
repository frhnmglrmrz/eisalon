<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\XenditWebhookController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\Admin\AdminTherapistController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\AdminReviewController;
use App\Http\Controllers\Admin\AdminNotificationController;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/api/home-stats', [HomeController::class, 'apiStats'])->name('home.api-stats');

// Services Listing
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');

// E-Catalog (Public)
Route::get('catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('catalog/booking/{service}', [CatalogController::class, 'showBookingForm'])->name('catalog.booking');
Route::post('catalog/booking/{service}', [CatalogController::class, 'storeBooking'])->name('catalog.booking.store');
Route::get('catalog/api/slots', [CatalogController::class, 'availableSlots'])->name('catalog.api.slots');
Route::get('catalog/booking/success/{booking}', [CatalogController::class, 'success'])->name('catalog.booking.success');
Route::get('catalog/booking/receipt/{booking}', [CatalogController::class, 'receipt'])->name('catalog.booking.receipt');

// Database Check (for testing only)
Route::get('/check-database', function() {
    $data = [
        'status' => 'Database is working! ✅',
        'database_path' => database_path('database.sqlite'),
        'database_exists' => file_exists(database_path('database.sqlite')),
        'database_size' => file_exists(database_path('database.sqlite')) ? 
            round(filesize(database_path('database.sqlite')) / 1024, 2) . ' KB' : 'N/A',
        'data_counts' => [
            'services' => \App\Models\Service::count(),
            'users' => \App\Models\User::count(),
            'therapists' => \App\Models\Therapist::count(),
            'bookings' => \App\Models\Booking::count(),
            'payments' => \App\Models\Payment::count(),
            'reviews' => \App\Models\Review::count(),
        ],
        'sample_services' => \App\Models\Service::take(3)->get(['id', 'name', 'price', 'category']),
        'all_users' => \App\Models\User::all(['id', 'name', 'email', 'created_at']),
    ];
    
    return response()->json($data, 200, [], JSON_PRETTY_PRINT);
});

// Test Notification Route
Route::get('/test-notification', function() {
    $user = auth()->user();
    if (!$user) return redirect('login');
    
    // Create dummy booking if not exists
    $booking = \App\Models\Booking::first();
    if (!$booking) {
        // Create dummy booking logic here if needed, or just fail gracefully
        return "Please create a booking first";
    }
    
    // Send notification
    $user->notify(new \App\Notifications\PaymentConfirmed($booking));
    
    return back()->with('success', 'Test notification sent!');
});

// Services
Route::resource('services', ServiceController::class);
Route::get('services/category/{category}', [ServiceController::class, 'getByCategory'])
    ->name('services.by-category');

// Customer Routes (requires authentication and customer role)
Route::middleware(['customer'])->group(function () {
    Route::get('bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('bookings', [BookingController::class, 'store'])->name('bookings.store');
    
    // Available slots (API endpoint) - MUST be before {booking} wildcard
    Route::get('bookings/available-slots', [BookingController::class, 'getAvailableSlots'])
        ->name('bookings.available-slots');

    Route::get('bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    
    // Payment callback routes
    Route::get('bookings/{booking}/payment/success', [BookingController::class, 'paymentSuccess'])
        ->name('booking.success');
    Route::get('bookings/{booking}/payment/failed', [BookingController::class, 'paymentFailed'])
        ->name('booking.failed');
    
    // Reviews
    Route::post('bookings/{booking}/reviews', [ReviewController::class, 'store'])
        ->name('reviews.store');
    Route::put('reviews/{review}', [ReviewController::class, 'update'])
        ->name('reviews.update');
    Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])
        ->name('reviews.destroy');

    // Notifications
    Route::post('notifications/mark-all-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])
        ->name('notifications.mark-all-read');
    Route::get('notifications/{id}/mark-read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])
        ->name('notifications.mark-read');
});

// Admin Routes (requires authentication and admin role)
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // CRUD Routes
    Route::resource('services', AdminServiceController::class);
    Route::resource('therapists', AdminTherapistController::class);
    Route::resource('bookings', AdminBookingController::class);
    Route::resource('payments', AdminPaymentController::class)->except(['create', 'store', 'edit', 'update']);
    Route::post('payments/{payment}/update-status', [AdminPaymentController::class, 'updateStatus'])->name('payments.update-status');
    Route::resource('reviews', AdminReviewController::class)->except(['create', 'store']);
    Route::get('notifications', [AdminNotificationController::class, 'index'])->name('notifications.index');
    Route::resource('slots', \App\Http\Controllers\Admin\AdminSlotController::class)->except(['show', 'edit', 'update']);
});

// Xendit Webhook (no CSRF protection needed)
Route::post('webhooks/xendit', [XenditWebhookController::class, 'handle'])
    ->name('xendit.webhook')
    ->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);

require __DIR__.'/auth.php';
