<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPaymentReceived extends Notification
{
    use Queueable;

    protected $booking;

    /**
     * Create a new notification instance.
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'amount' => $this->booking->total_price,
            'user_name' => $this->booking->user->name,
            'service_name' => $this->booking->service->name,
            'message' => 'New payment of Rp ' . number_format($this->booking->total_price) . ' received from ' . $this->booking->user->name,
            'type' => 'payment_received',
            'link' => route('bookings.show', $this->booking->id) // Nanti bisa diarahkan ke admin dashboard
        ];
    }
}
