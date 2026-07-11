<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'service', 'slot']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->where('booking_date', $request->date);
        }

        // Search by customer name, phone, or ID
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', $search)
                  ->orWhere('guest_name', 'like', '%' . $search . '%')
                  ->orWhere('guest_phone', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%')
                                ->orWhere('phone', 'like', '%' . $search . '%');
                  });
            });
        }

        $bookings = $query->orderBy('booking_date', 'desc')
            ->orderBy('booking_time', 'desc')
            ->paginate(15);
        
        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $booking->load(['user', 'service', 'slot']);
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Update the specified resource's status.
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $booking->update([
            'status' => $validated['status']
        ]);

        // Kirim notifikasi WA otomatis menggunakan Fonnte API
        $this->sendFonnteNotification($booking);

        return redirect()->back()
            ->with('success', 'Status reservasi #' . $booking->id . ' berhasil diubah menjadi ' . ucfirst($validated['status']) . ' dan notifikasi WhatsApp otomatis telah dikirim.');
    }

    /**
     * Send automatic WhatsApp notification using Fonnte API
     */
    protected function sendFonnteNotification(Booking $booking)
    {
        $booking->load(['user', 'service']);
        
        $customerName = $booking->user ? $booking->user->name : $booking->guest_name;
        $customerPhone = $booking->user ? $booking->user->phone : $booking->guest_phone;
        
        // Bersihkan format nomor telepon pelanggan
        $customerPhone = preg_replace('/[^0-9]/', '', $customerPhone);
        if (str_starts_with($customerPhone, '0')) {
            $customerPhone = '62' . substr($customerPhone, 1);
        }

        $dateFormatted = \Carbon\Carbon::parse($booking->booking_date)->format('d F Y');
        $timeFormatted = \Carbon\Carbon::parse($booking->booking_time)->format('H:i');
        if ($booking->status === 'confirmed') {
            $message = "Halo {$customerName},\n\n" .
                       "Kami dari *Alan's Art Hair Salon* menginformasikan bahwa reservasi Anda telah **TERKONFIRMASI**:\n" .
                       "- **ID Booking**: #{$booking->id}\n" .
                       "- **Layanan**: {$booking->service->name}\n" .
                       "- **Jadwal**: {$dateFormatted} jam {$timeFormatted} WIB\n\n" .
                       "Sampai jumpa di salon! 😊";
        } elseif ($booking->status === 'cancelled') {
            $message = "Halo {$customerName},\n\n" .
                       "Kami dari *Alan's Art Hair Salon* menginformasikan bahwa reservasi Anda dengan ID #{$booking->id} telah **DIBATALKAN**.\n\n" .
                       "Mohon maaf atas ketidaknyamanannya. Silakan ajukan reservasi ulang jika berkenan. Terima kasih.";
        } elseif ($booking->status === 'completed') {
            $message = "Halo {$customerName},\n\n" .
                       "Terima kasih telah melakukan perawatan di *Alan's Art Hair Salon*!\n" .
                       "Reservasi ID #{$booking->id} Anda telah ditandai **SELESAI**.\n\n" .
                       "Kami harap Anda senang dengan hasilnya. Ditunggu kunjungan berikutnya! Barber & Stylist kami siap melayani Anda kembali.";
        } else {
            $message = "Halo {$customerName},\n\n" .
                       "Kami mengonfirmasi bahwa reservasi Anda dengan ID #{$booking->id} saat ini berstatus **PENDING** (Menunggu Konfirmasi).\n" .
                       "- **Layanan**: {$booking->service->name}\n" .
                       "- **Jadwal**: {$dateFormatted} jam {$timeFormatted} WIB\n\n" .
                       "Kami akan segera mengirimkan konfirmasi. Terima kasih.";
        }

        try {
            $token = config('services.fonnte.token', 'BzRjogWdCtZhCJzmAWCK');
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => $token,
            ])->post('https://api.fonnte.com/send', [
                'target' => $customerPhone,
                'message' => $message,
            ]);

            if ($response->successful()) {
                $booking->update(['whatsapp_sent_at' => now()]);
            } else {
                \Illuminate\Support\Facades\Log::error('Fonnte API failed to send WhatsApp notification: ' . $response->body());
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Exception during Fonnte API notification send: ' . $e->getMessage());
        }
    }
}
