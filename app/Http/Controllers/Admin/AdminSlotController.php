<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slot;
use Illuminate\Http\Request;

class AdminSlotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Slot::query();

        if ($request->filled('date')) {
            $query->where('date', $request->date);
        }

        $slots = $query->orderBy('date', 'desc')
            ->orderBy('start_time', 'asc')
            ->paginate(15);

        return view('admin.slots.index', compact('slots'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.slots.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'is_available' => 'boolean',
        ]);

        // Pastikan format waktu H:i:00
        $validated['start_time'] = date('H:i:00', strtotime($validated['start_time']));
        $validated['end_time'] = date('H:i:00', strtotime($validated['end_time']));
        $validated['is_available'] = $request->has('is_available') ? $request->boolean('is_available') : true;

        // Cek duplicate slot
        $exists = Slot::where('date', $validated['date'])
            ->where('start_time', $validated['start_time'])
            ->where('end_time', $validated['end_time'])
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Slot pada tanggal dan jam tersebut sudah ada.');
        }

        Slot::create($validated);

        return redirect()->route('admin.slot.index')
            ->with('success', 'Slot jadwal berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slot $slot)
    {
        return view('admin.slots.edit', compact('slot'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slot $slot)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'is_available' => 'boolean',
        ]);

        $validated['start_time'] = date('H:i:00', strtotime($validated['start_time']));
        $validated['end_time'] = date('H:i:00', strtotime($validated['end_time']));
        $validated['is_available'] = $request->has('is_available') ? $request->boolean('is_available') : false;

        // Cek duplicate slot pada ID yang berbeda
        $exists = Slot::where('date', $validated['date'])
            ->where('start_time', $validated['start_time'])
            ->where('end_time', $validated['end_time'])
            ->where('id', '!=', $slot->id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Slot pada tanggal dan jam tersebut sudah ada.');
        }

        $slot->update($validated);

        return redirect()->route('admin.slot.index')
            ->with('success', 'Slot jadwal berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slot $slot)
    {
        // Cek jika slot memiliki booking aktif
        if ($slot->bookings()->exists()) {
            $slot->update(['is_available' => false]);
            return redirect()->route('admin.slot.index')
                ->with('warning', 'Slot tidak dapat dihapus karena memiliki riwayat booking. Status diubah menjadi Tidak Tersedia.');
        }

        $slot->delete();

        return redirect()->route('admin.slot.index')
            ->with('success', 'Slot jadwal berhasil dihapus.');
    }
}
