<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use App\Models\Stylist;
use App\Models\Slot;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Show the booking form
     */
    public function create(Request $request)
    {
        $services = Service::active()->get();
        $selectedServiceId = $request->input('service_id');
        
        return view('bookings.create', compact('services', 'selectedServiceId'));
    }

    /**
     * Store a new booking
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'date' => 'required|date|after_or_equal:today',
            'slot_id' => 'required|exists:slots,id',
            'stylist_id' => 'nullable|exists:stylists,id',
            'notes' => 'nullable|string|max:500',
            'payment_proof' => 'required|image|max:2048', // Bukti transfer gambar, maks 2MB
        ]);

        // 2. Dapatkan Objek Terkait
        $service = Service::findOrFail($validated['service_id']);
        $slot = Slot::findOrFail($validated['slot_id']);
        
        // Pastikan tanggal slot cocok dengan input date
        if ($slot->date->format('Y-m-d') !== $validated['date']) {
            return back()->withErrors(['date' => 'Tanggal slot tidak cocok dengan tanggal yang dipilih.'])->withInput();
        }

        // 3. Tentukan & Validasi Stylist
        $assignedStylistId = null;

        if ($request->filled('stylist_id')) {
            $stylistId = $request->stylist_id;
            $stylist = Stylist::available()
                ->where(function($q) use ($service) {
                    $q->where('specialization', 'like', '%' . $service->category . '%')
                      ->orWhereNull('specialization')
                      ->orWhere('specialization', '');
                })
                ->where('id', $stylistId)
                ->first();

            if (!$stylist) {
                return back()->withErrors(['stylist_id' => 'Stylist tersebut tidak tersedia untuk kategori layanan ini.'])->withInput();
            }

            // Cek ketersediaan slot untuk stylist ini
            $isBooked = Booking::where('slot_id', $slot->id)
                ->where('booking_date', $validated['date'])
                ->where('stylist_id', $stylistId)
                ->whereIn('status', ['pending', 'confirmed', 'completed'])
                ->exists();

            if ($isBooked) {
                return back()->withErrors(['slot_id' => 'Stylist yang dipilih sudah memiliki jadwal lain di jam ini.'])->withInput();
            }

            $assignedStylistId = $stylistId;
        } else {
            // Cari stylist yang cocok dan tersedia
            $availableStylist = Stylist::available()
                ->where(function($q) use ($service) {
                    $q->where('specialization', 'like', '%' . $service->category . '%')
                      ->orWhereNull('specialization')
                      ->orWhere('specialization', '');
                })
                ->whereDoesntHave('bookings', function($q) use ($slot, $validated) {
                    $q->where('slot_id', $slot->id)
                      ->where('booking_date', $validated['date'])
                      ->whereIn('status', ['pending', 'confirmed', 'completed']);
                })
                ->first();

            if (!$availableStylist) {
                return back()->withErrors(['slot_id' => 'Semua stylist untuk kategori layanan ini sudah penuh pada slot jam terpilih.'])->withInput();
            }

            $assignedStylistId = $availableStylist->id;
        }

        // 4. Proses Upload Bukti Pembayaran
        $paymentProofPath = null;
        if ($request->hasFile('payment_proof')) {
            $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

        // 5. Hubungkan ke User Terautentikasi
        $user = Auth::user();

        // 6. Simpan Booking
        $booking = Booking::create([
            'user_id' => $user->id,
            'guest_name' => null,
            'guest_phone' => null,
            'guest_email' => null,
            'service_id' => $service->id,
            'stylist_id' => $assignedStylistId,
            'slot_id' => $slot->id,
            'booking_date' => $validated['date'],
            'booking_time' => $slot->start_time,
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
            'payment_proof' => $paymentProofPath,
        ]);

        return redirect()->route('booking.success', $booking)
            ->with('success', 'Reservasi berhasil dibuat! Bukti pembayaran Anda sedang diverifikasi oleh admin.');
    }

    /**
     * Show success page
     */
    public function success(Booking $booking)
    {
        $booking->load(['service', 'stylist', 'slot']);
        return view('bookings.success', compact('booking'));
    }
}
