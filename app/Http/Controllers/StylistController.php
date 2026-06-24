<?php

namespace App\Http\Controllers;

use App\Models\Stylist;
use App\Models\Service;
use App\Models\Booking;
use App\Models\Slot;
use Illuminate\Http\Request;

class StylistController extends Controller
{
    /**
     * Get available stylists for a given date, slot, and service
     */
    public function available(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'slot_id' => 'required|exists:slots,id',
            'service_id' => 'required|exists:services,id',
        ]);

        $date = $validated['date'];
        $slotId = $validated['slot_id'];
        $service = Service::findOrFail($validated['service_id']);

        // Ambil semua stylist yang aktif
        $stylists = Stylist::available()
            ->where(function($q) use ($service) {
                $q->where('specialization', 'like', '%' . $service->category . '%')
                  ->orWhereNull('specialization')
                  ->orWhere('specialization', '');
            })
            ->get();

        $result = [];

        foreach ($stylists as $stylist) {
            // Cek apakah stylist ini sudah dibooking pada tanggal & slot ini
            $isBooked = Booking::where('slot_id', $slotId)
                ->where('booking_date', $date)
                ->where('stylist_id', $stylist->id)
                ->whereIn('status', ['pending', 'confirmed', 'completed'])
                ->exists();

            if (!$isBooked) {
                $result[] = [
                    'id' => $stylist->id,
                    'name' => $stylist->name,
                    'specialization' => $stylist->specialization,
                    'bio' => $stylist->bio,
                    'photo' => $stylist->photo ? asset('storage/' . $stylist->photo) : asset('images/default-stylist.jpg'),
                ];
            }
        }

        return response()->json(['stylists' => $result]);
    }
}
