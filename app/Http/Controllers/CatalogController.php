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

    /**
     * Show booking form for WhatsApp
     */
    public function showBookingForm(Service $service)
    {
        return view('catalog.booking-form', compact('service'));
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

        // Format date for message
        $formattedDate = $bookingDateTime->locale('id')->isoFormat('dddd, D MMMM YYYY');
        $formattedTime = $bookingDateTime->format('H:i');

        // Create WhatsApp message
        $whatsappMessage = "Halo, saya ingin memesan layanan:\n\n";
        $whatsappMessage .= "*Layanan:* {$service->name}\n";
        $whatsappMessage .= "*Harga:* Rp " . number_format($service->price, 0, ',', '.') . "\n";
        $whatsappMessage .= "*Durasi:* {$service->duration} menit\n\n";
        $whatsappMessage .= "*Data Pemesanan:*\n";
        $whatsappMessage .= "Nama: {$validated['name']}\n";
        $whatsappMessage .= "Nomor WhatsApp: {$validated['phone']}\n";
        $whatsappMessage .= "Tanggal: {$formattedDate}\n";
        $whatsappMessage .= "Waktu: {$formattedTime}\n";
        if (!empty($validated['notes'])) {
            $whatsappMessage .= "Catatan: {$validated['notes']}\n";
        }
        $whatsappMessage .= "\nMohon konfirmasi ketersediaan untuk waktu tersebut. Terima kasih!";

        // Save to database
        $whatsappBooking = WhatsAppBooking::create([
            'service_id' => $service->id,
            'customer_name' => $validated['name'],
            'customer_phone' => $validated['phone'],
            'customer_email' => $validated['email'] ?? null,
            'booking_date' => $bookingDateTime,
            'notes' => $validated['notes'] ?? null,
            'total_price' => $service->price,
            'payment_status' => 'pending',
            'payment_method' => 'whatsapp',
            'whatsapp_message' => $whatsappMessage,
        ]);

        // Get WhatsApp number from config
        $whatsappNumber = config('services.whatsapp.phone_number', '6281234567890');
        
        // Encode message for URL
        $encodedMessage = urlencode($whatsappMessage);
        
        // Create WhatsApp URL
        $whatsappUrl = "https://wa.me/{$whatsappNumber}?text={$encodedMessage}";

        // Redirect to WhatsApp
        return redirect()->away($whatsappUrl)->with('success', 'Pemesanan berhasil disimpan! Anda akan diarahkan ke WhatsApp.');
    }
}
