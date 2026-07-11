<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function index()
    {
        // Hitung total pendapatan dari booking yang 'completed'
        $totalRevenue = Booking::where('bookings.status', 'completed')
            ->join('services', 'bookings.service_id', '=', 'services.id')
            ->sum('services.price');

        $stats = [
            'total_users' => User::where('role', 'customer')->count(),
            'total_bookings' => Booking::count(),
            'total_services' => Service::count(),
            'total_revenue' => $totalRevenue,
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'confirmed_bookings' => Booking::where('status', 'confirmed')->count(),
            'completed_bookings' => Booking::where('status', 'completed')->count(),
        ];

        $recent_bookings = Booking::with(['user', 'service', 'slot'])
            ->latest()
            ->take(8)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_bookings'));
    }
}
