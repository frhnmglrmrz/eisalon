<?php

use Illuminate\Support\Facades\Route;

// Database verification route (temporary for testing)
Route::get('/check-database', function() {
    $data = [
        'database_path' => database_path('database.sqlite'),
        'database_exists' => file_exists(database_path('database.sqlite')),
        'database_size' => file_exists(database_path('database.sqlite')) ? 
            round(filesize(database_path('database.sqlite')) / 1024, 2) . ' KB' : 'N/A',
        'counts' => [
            'services' => \App\Models\Service::count(),
            'users' => \App\Models\User::count(),
            'therapists' => \App\Models\Therapist::count(),
            'bookings' => \App\Models\Booking::count(),
            'payments' => \App\Models\Payment::count(),
            'reviews' => \App\Models\Review::count(),
        ],
        'sample_services' => \App\Models\Service::take(3)->get(['id', 'name', 'price', 'category']),
        'sample_users' => \App\Models\User::all(['id', 'name', 'email']),
    ];
    
    return response()->json($data, 200, [], JSON_PRETTY_PRINT);
});
