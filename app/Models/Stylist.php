<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Stylist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'specialization',
        'bio',
        'photo',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    /**
     * Get bookings for the stylist
     *
     * @return HasMany
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Scope for available stylists
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('is_available', true);
    }

    /**
     * Check if stylist is available at a given slot and date
     *
     * @param mixed $slotId
     * @param mixed $date
     * @return bool
     */
    public function isAvailableAt($slotId, $date): bool
    {
        return !$this->bookings()
            ->where('slot_id', $slotId)
            ->where('booking_date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();
    }
}
