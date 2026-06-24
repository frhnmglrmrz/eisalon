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
        // 1. Validasi Input Dasar
        $rules = [
            'service_id' => 'required|exists:services,id',
            'date' => 'required|date|after_or_equal:today',
            'slot_id' => 'required|exists:slots,id',
            'stylist_id' => 'nullable|exists:stylists,id',
            'notes' => 'nullable|string|max:500',
        ];

        // Jika tidak masuk log (guest), wajib isi data kontak
        if (!Auth::check()) {
            $rules['guest_name'] = 'required|string|max:255';
            $rules['guest_phone'] = 'required|string|max:20';
            $rules['guest_email'] = 'required|email|max:255';
        }

        $validated = $request->validate($rules);

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

        // 4. Hubungkan ke User atau Buat User Baru untuk Guest
        $user = null;
        $tempPassword = null;

        if (Auth::check()) {
            $user = Auth::user();
        } else {
            $email = $validated['guest_email'];
            $user = User::where('email', $email)->first();
            
            if (!$user) {
                // Buat user baru otomatis
                $tempPassword = Str::random(8);
                $user = User::create([
                    'name' => $validated['guest_name'],
                    'email' => $email,
                    'phone' => $validated['guest_phone'],
                    'password' => Hash::make($tempPassword),
                    'role' => 'customer',
                ]);
            }
        }

        // 5. Simpan Booking
        $booking = Booking::create([
            'user_id' => $user->id,
            'guest_name' => Auth::check() ? null : $validated['guest_name'],
            'guest_phone' => Auth::check() ? null : $validated['guest_phone'],
            'guest_email' => Auth::check() ? null : $validated['guest_email'],
            'service_id' => $service->id,
            'stylist_id' => $assignedStylistId,
            'slot_id' => $slot->id,
            'booking_date' => $validated['date'],
            'booking_time' => $slot->start_time,
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);

        if ($tempPassword) {
            session()->flash('new_user_created', [
                'email' => $user->email,
                'password' => $tempPassword
            ]);
        }

        return redirect()->route('booking.success', $booking)
            ->with('success', 'Reservasi berhasil dibuat! Silakan lakukan konfirmasi via WhatsApp.');
    }

    /**
     * Show success page and WhatsApp confirmation link
     */
    public function success(Booking $booking)
    {
        $booking->load(['service', 'stylist', 'slot']);
        
        // Cari admin untuk nomor telepon WhatsApp
        $admin = User::where('role', 'admin')->first();
        $adminPhone = $admin ? $admin->phone : '6289523808660';
        
        // Bersihkan format nomor telepon agar diawali kode negara
        $adminPhone = preg_replace('/[^0-9]/', '', $adminPhone);
        if (str_starts_with($adminPhone, '0')) {
            $adminPhone = '62' . substr($adminPhone, 1);
        }

        // Generate teks WhatsApp
        $customerName = $booking->user ? $booking->user->name : ($booking->guest_name ?? 'Pelanggan');
        $dateFormatted = \Carbon\Carbon::parse($booking->booking_date)->format('d F Y');
        $timeFormatted = \Carbon\Carbon::parse($booking->booking_time)->format('H:i');
        $stylistName = $booking->stylist ? $booking->stylist->name : 'Pilih Acak (Siapa Saja)';

        $message = "Halo Admin Alan's Art Hair Salon,\n\n" .
                   "Saya ingin mengonfirmasi pemesanan reservasi saya:\n" .
                   "- **ID Booking**: #{$booking->id}\n" .
                   "- **Nama**: {$customerName}\n" .
                   "- **Layanan**: {$booking->service->name}\n" .
                   "- **Stylist**: {$stylistName}\n" .
                   "- **Jadwal**: {$dateFormatted} jam {$timeFormatted}\n" .
                   "- **Total**: Rp " . number_format($booking->service->price, 0, ',', '.') . "\n\n" .
                   "Mohon untuk mengonfirmasi jadwal pemesanan saya. Terima kasih!";

        $whatsappUrl = "https://wa.me/{$adminPhone}?text=" . urlencode($message);

        return view('bookings.success', compact('booking', 'whatsappUrl'));
    }
}
