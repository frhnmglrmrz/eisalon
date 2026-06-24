<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'guest_name',
        'guest_phone',
        'guest_email',
        'service_id',
        'stylist_id',
        'slot_id',
        'booking_date',
        'booking_time',
        'status',
        'notes',
        'whatsapp_sent_at',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'whatsapp_sent_at' => 'datetime',
    ];

    // Relationships
    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * @return BelongsTo
     */
    public function stylist(): BelongsTo
    {
        return $this->belongsTo(Stylist::class);
    }

    /**
     * @return BelongsTo
     */
    public function slot(): BelongsTo
    {
        return $this->belongsTo(Slot::class);
    }

    // Scopes
    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeConfirmed(Builder $query): Builder
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', 'completed');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('booking_date', '>', now())
                     ->whereIn('status', ['pending', 'confirmed']);
    }

    /**
     * Check if booking can be cancelled (only if pending/confirmed and > 24 hours prior)
     *
     * @return bool
     */
    public function canBeCancelled(): bool
    {
        if (!in_array($this->status, ['pending', 'confirmed'])) {
            return false;
        }

        $bookingDateTime = \Carbon\Carbon::parse($this->booking_date->format('Y-m-d') . ' ' . $this->booking_time);
        return $bookingDateTime->isAfter(now()->addHours(24));
    }
}
