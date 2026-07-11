<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;

class SlotController extends Controller
{
    /**
     * Get available slots for a given date and service
     */
    public function available(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'service_id' => 'required|exists:services,id',
        ]);

        $date = $validated['date'];

        // Ambil semua slot jadwal yang aktif untuk tanggal terpilih
        $slots = Slot::where('date', $date)
            ->where('is_available', true)
            ->orderBy('start_time')
            ->get();

        $result = [];

        foreach ($slots as $slot) {
            // Cek apakah slot ini sudah dibooking pada tanggal terpilih
            $isBooked = Booking::where('slot_id', $slot->id)
                ->where('booking_date', $date)
                ->whereIn('status', ['pending', 'confirmed', 'completed'])
                ->exists();

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
