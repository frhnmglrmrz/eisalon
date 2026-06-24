<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerBookingController extends Controller
{
    /**
     * Display user's bookings
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $bookings = Booking::where('user_id', $user->id)
            ->with(['service', 'stylist', 'slot'])
            ->orderBy('booking_date', 'desc')
            ->orderBy('booking_time', 'desc')
            ->paginate(10);

        return view('customer.bookings.index', compact('bookings'));
    }

    /**
     * Cancel a booking
     */
    public function cancel(Booking $booking)
    {
        // Pastikan booking milik user yang login
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        // Cek apakah booking bisa dibatalkan (misal H-1 / 24 jam sebelum)
        if (!$booking->canBeCancelled()) {
            return redirect()->back()
                ->with('error', 'Pemesanan tidak dapat dibatalkan karena waktu janji temu kurang dari 24 jam.');
        }

        $booking->update([
            'status' => 'cancelled'
        ]);

        return redirect()->back()
            ->with('success', 'Reservasi berhasil dibatalkan.');
    }
}
