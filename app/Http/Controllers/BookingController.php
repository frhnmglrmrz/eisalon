<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use App\Models\Therapist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display user's bookings
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $bookings = $user->bookings()
            ->with(['service', 'therapist', 'payment'])
            ->orderBy('booking_date', 'desc')
            ->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the booking form
     */
    public function create(Request $request)
    {
        $service = Service::findOrFail($request->service_id);
        $therapists = Therapist::available()
            ->bySpecialization($service->category)
            ->get();

        return view('bookings.create', compact('service', 'therapists'));
    }

    /**
     * Store a new booking
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'therapist_id' => 'nullable|exists:therapists,id',
            'booking_date' => 'required|date|after:now',
            'notes' => 'nullable|string|max:500',
        ]);

        $service = Service::findOrFail($validated['service_id']);

        // Validasi ketersediaan terapis
        if (isset($validated['therapist_id'])) {
            $therapist = Therapist::findOrFail($validated['therapist_id']);
            if (!$therapist->isAvailableAt($validated['booking_date'])) {
                return back()->withErrors([
                    'booking_date' => 'Therapist is not available at the selected time'
                ])->withInput();
            }
        } else {
            // Check if there is at least one therapist available for this service category at the selected time
            $availableTherapistsCount = Therapist::available()
                ->bySpecialization($service->category)
                ->whereDoesntHave('bookings', function ($query) use ($validated) {
                    $query->where('booking_date', $validated['booking_date'])
                          ->whereIn('status', ['pending', 'confirmed', 'in_progress']);
                })
                ->count();

            if ($availableTherapistsCount === 0) {
                return back()->withErrors([
                    'booking_date' => 'No therapists specializing in this service category are available at the selected time'
                ])->withInput();
            }
        }

        // Create booking
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $booking = Booking::create([
            'user_id' => $user->id,
            'service_id' => $validated['service_id'],
            'therapist_id' => $validated['therapist_id'] ?? null,
            'booking_date' => $validated['booking_date'],
            'notes' => $validated['notes'] ?? null,
            'total_price' => $service->price,
            'status' => 'pending',
        ]);

        // Create manual Payment record
        $payment = \App\Models\Payment::create([
            'booking_id' => $booking->id,
            'xendit_invoice_id' => 'WA-' . $booking->id . '-' . time(), // Dummy ID for manual payment
            'amount' => $booking->total_price,
            'status' => 'pending',
            'payment_method' => 'Manual Transfer',
        ]);

        // Construct WhatsApp Message
        $admin = \App\Models\User::where('role', 'admin')->first();
        $phoneNumber = $admin->phone ?? '089523808660'; // Admin Phone Number from DB with fallback
        $message = "Halo Admin, saya ingin konfirmasi booking:\n\n" .
                   "Booking ID: #{$booking->id}\n" .
                   "Nama: {$user->name}\n" .
                   "Service: {$service->name}\n" .
                   "Tanggal: {$validated['booking_date']}\n" .
                   "Total: Rp " . number_format($booking->total_price, 0, ',', '.') . "\n\n" .
                   "Mohon info pembayaran selanjutnya. Terima kasih.";

        $whatsappUrl = "https://wa.me/{$phoneNumber}?text=" . urlencode($message);

        return redirect()->away($whatsappUrl);
    }

    /**
     * Display the specified booking
     */
    public function show(Booking $booking)
    {
        // Ensure user can only view their own bookings
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($booking->user_id !== $user->id) {
            abort(403, 'Unauthorized access');
        }

        $booking->load(['service', 'therapist', 'payment', 'review']);

        return view('bookings.show', compact('booking'));
    }

    /**
     * Cancel a booking
     */
    public function cancel(Booking $booking)
    {
        // Ensure user can only cancel their own bookings
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($booking->user_id !== $user->id) {
            abort(403, 'Unauthorized access');
        }

        if (!$booking->canBeCancelled()) {
            return back()->withErrors([
                'booking' => 'This booking cannot be cancelled'
            ]);
        }

        $booking->update(['status' => 'cancelled']);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking cancelled successfully');
    }

    /**
     * Payment success redirect
     */
    public function paymentSuccess(Booking $booking)
    {
        return redirect()->route('bookings.index')
            ->with('success', 'Payment successful! Your booking for ' . $booking->service->name . ' is confirmed.');
    }

    /**
     * Payment failed redirect
     */
    public function paymentFailed(Booking $booking)
    {
        return view('bookings.payment-failed', compact('booking'));
    }

    /**
     * Get available time slots for a service and therapist
     */
    public function getAvailableSlots(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'therapist_id' => 'nullable|exists:therapists,id',
            'date' => 'required|date',
        ]);

        $service = Service::findOrFail($validated['service_id']);
        $date = $validated['date'];

        // Business hours: 9 AM - 9 PM
        $startHour = 9;
        $endHour = 21;

        $slots = [];

        for ($hour = $startHour; $hour < $endHour; $hour++) {
            $timeSlot = $date . ' ' . str_pad($hour, 2, '0', STR_PAD_LEFT) . ':00:00';

            // Check if slot is available
            if (isset($validated['therapist_id'])) {
                $isBooked = Booking::where('booking_date', $timeSlot)
                    ->where('therapist_id', $validated['therapist_id'])
                    ->whereIn('status', ['pending', 'confirmed', 'in_progress'])
                    ->exists();
            } else {
                $availableTherapistsCount = Therapist::available()
                    ->bySpecialization($service->category)
                    ->whereDoesntHave('bookings', function ($query) use ($timeSlot) {
                        $query->where('booking_date', $timeSlot)
                              ->whereIn('status', ['pending', 'confirmed', 'in_progress']);
                    })
                    ->count();
                
                $isBooked = ($availableTherapistsCount === 0);
            }

            $slots[] = [
                'time' => date('H:i', strtotime($timeSlot)),
                'datetime' => $timeSlot,
                'is_available' => !$isBooked,
            ];
        }

        return response()->json($slots);
    }
}
