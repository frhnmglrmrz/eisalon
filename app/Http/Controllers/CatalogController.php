<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\WhatsAppBooking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CatalogController extends Controller
{
    /**
     * Display e-catalog page with all services
     */
    public function index(Request $request)
    {
        $query = Service::with(['reviews'])->active();

        // Filter by category
        if ($request->has('category') && $request->category !== '') {
            $query->byCategory($request->category);
        }

        // Search
        if ($request->has('search') && $request->search !== '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Get all categories for filter
        $categories = Service::active()
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        // Get services grouped by category
        $servicesByCategory = Service::active()
            ->with(['reviews'])
            ->orderBy('category')
            ->orderBy('name')
            ->get()
            ->groupBy('category');

        // Paginated services for main display
        $services = $query->orderBy('category')->orderBy('name')->paginate(12);

        // Append computed attributes
        $services->getCollection()->transform(function ($service) {
            $service->average_rating = $service->average_rating;
            $service->total_reviews = $service->total_reviews;
            return $service;
        });

        return view('catalog.index', compact('services', 'categories', 'servicesByCategory'));
    }

    public function showBookingForm(Service $service)
    {
        return view('catalog.booking-form', compact('service'));
    }

    public function availableSlots(Request $request)
    {
        $date = $request->query('date', date('Y-m-d'));
        $slots = \App\Models\BookingSlot::where('date', $date)
            ->where('is_booked', false)
            ->orderBy('time')
            ->get(['id', 'time']);

        // Format times to H:i
        $slots->transform(function ($slot) {
            $slot->time = \Carbon\Carbon::parse($slot->time)->format('H:i');
            return $slot;
        });

        return response()->json(['slots' => $slots]);
    }

    /**
     * Store WhatsApp booking and redirect to WhatsApp
     */
    public function storeBooking(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'notes' => 'nullable|string',
        ]);

        // Combine date and time
        $bookingDateTime = Carbon::createFromFormat('Y-m-d H:i', $validated['date'] . ' ' . $validated['time']);

        // Format phone number
        $formattedPhone = preg_replace('/^0/', '62', $validated['phone']);
        $formattedPhone = preg_replace('/\D/', '', $formattedPhone);

        // Get or Create User
        $user = \Illuminate\Support\Facades\Auth::user();
        if (!$user) {
            $user = \App\Models\User::firstOrCreate(
                ['phone' => $formattedPhone],
                [
                    'name' => $validated['name'],
                    'email' => $validated['email'] ?? $formattedPhone . '@eisalon.local',
                    'password' => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(12)),
                    'role' => 'customer',
                ]
            );
        }

        // Create the booking in main table
        $booking = \App\Models\Booking::create([
            'user_id' => $user->id,
            'service_id' => $service->id,
            'booking_date' => $bookingDateTime,
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
            'total_price' => $service->price,
        ]);

        // Mark slot as booked
        \App\Models\BookingSlot::where('date', $validated['date'])
            ->where('time', \Carbon\Carbon::parse($validated['time'])->format('H:i:s'))
            ->update(['is_booked' => true]);

        // Redirect to success page
        return redirect()->route('catalog.booking.success', $booking->id);
    }

    public function success(\App\Models\Booking $booking)
    {
        // Get Admin WhatsApp number from database
        $admin = \App\Models\User::where('role', 'admin')->first();
        $whatsappNumber = $admin->phone ?? '089523808660'; 
        
        if (str_starts_with($whatsappNumber, '0')) {
            $whatsappNumber = '62' . substr($whatsappNumber, 1);
        }

        return view('catalog.success', compact('booking', 'whatsappNumber'));
    }

    public function receipt(\App\Models\Booking $booking)
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.receipt', compact('booking'));
        return $pdf->download('struk-booking-eisalon-' . $booking->id . '.pdf');
    }
}
