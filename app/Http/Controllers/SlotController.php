<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Stylist;
use Illuminate\Http\Request;

class SlotController extends Controller
{
    /**
     * Get available slots for a given date and service/stylist
     */
    public function available(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'service_id' => 'required|exists:services,id',
            'stylist_id' => 'nullable|exists:stylists,id',
        ]);

        $date = $validated['date'];
        $service = Service::findOrFail($validated['service_id']);
        $stylistId = $validated['stylist_id'] ?? null;

        // Ambil semua slot jadwal yang aktif untuk tanggal terpilih
        $slots = Slot::where('date', $date)
            ->where('is_available', true)
            ->orderBy('start_time')
            ->get();

        $result = [];

        foreach ($slots as $slot) {
            if ($stylistId) {
                // Cek apakah stylist spesifik tersebut sudah ada booking aktif di slot ini
                $isBooked = Booking::where('slot_id', $slot->id)
                    ->where('booking_date', $date)
                    ->where('stylist_id', $stylistId)
                    ->whereIn('status', ['pending', 'confirmed', 'completed'])
                    ->exists();
            } else {
                // Cek apakah semua stylist yang berspesialisasi dalam kategori layanan ini penuh di slot ini
                $availableStylistCount = Stylist::available()
                    ->where(function($q) use ($service) {
                        $q->where('specialization', 'like', '%' . $service->category . '%')
                          ->orWhereNull('specialization');
                    })
                    ->whereDoesntHave('bookings', function ($q) use ($slot, $date) {
                        $q->where('slot_id', $slot->id)
                          ->where('booking_date', $date)
                          ->whereIn('status', ['pending', 'confirmed', 'completed']);
                    })
                    ->count();

                $isBooked = ($availableStylistCount === 0);
            }

            $result[] = [
                'id' => $slot->id,
                'start_time' => date('H:i', strtotime($slot->start_time)),
                'end_time' => date('H:i', strtotime($slot->end_time)),
                'is_available' => !$isBooked,
            ];
        }

        return response()->json(['slots' => $result]);
    }
}
