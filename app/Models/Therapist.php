<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Therapist extends Model
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

    // Relationships
    /**
     * @return HasMany
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    // Scopes
    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('is_available', true);
    }

    /**
     * @param Builder $query
     * @param string $specialization
     * @return Builder
     */
    public function scopeBySpecialization(Builder $query, string $specialization): Builder
    {
        return $query->where('specialization', $specialization);
    }

    // Methods
    public function isAvailableAt($dateTime)
    {
        // Cek apakah terapis sudah ada booking di waktu tersebut
        return !$this->bookings()
            ->where('booking_date', $dateTime)
            ->whereIn('status', ['pending', 'confirmed', 'in_progress'])
            ->exists();
    }
}
