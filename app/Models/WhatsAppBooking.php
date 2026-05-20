<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsAppBooking extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_bookings';

    protected $fillable = [
        'service_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'booking_date',
        'notes',
        'total_price',
        'payment_status',
        'payment_method',
        'whatsapp_message',
    ];

    protected $casts = [
        'booking_date' => 'datetime',
        'total_price' => 'decimal:2',
    ];

    // Relationships
    /**
     * @return BelongsTo
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('payment_status', 'confirmed');
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    // Methods
    public function markAsConfirmed()
    {
        $this->update(['payment_status' => 'confirmed']);
    }

    public function markAsPaid()
    {
        $this->update(['payment_status' => 'paid']);
    }

    public function markAsCancelled()
    {
        $this->update(['payment_status' => 'cancelled']);
    }
}
