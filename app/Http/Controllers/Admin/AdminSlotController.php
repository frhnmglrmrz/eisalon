<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminSlotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $slots = \App\Models\BookingSlot::orderBy('date', 'desc')->orderBy('time', 'asc')->paginate(20);
        return view('admin.slots.index', compact('slots'));
    }

    public function create()
    {
        return view('admin.slots.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required',
        ]);

        \App\Models\BookingSlot::firstOrCreate([
            'date' => $request->date,
            'time' => $request->time,
        ]);

        return redirect()->route('admin.slots.index')->with('success', 'Slot created successfully.');
    }

    public function destroy($id)
    {
        \App\Models\BookingSlot::findOrFail($id)->delete();
        return redirect()->route('admin.slots.index')->with('success', 'Slot deleted successfully.');
    }
}
