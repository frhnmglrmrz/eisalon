<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'therapist_id',
        'booking_date',
        'status',
        'notes',
        'total_price',
    ];

    protected $casts = [
        'booking_date' => 'datetime',
        'total_price' => 'decimal:2',
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
    public function therapist(): BelongsTo
    {
        return $this->belongsTo(Therapist::class);
    }

    /**
     * @return HasOne
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * @return HasOne
     */
    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
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

    // Methods
    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'confirmed']) 
            && $this->booking_date > now()->addHours(24);
    }

    public function isPaid()
    {
        return $this->payment && $this->payment->status === 'paid';
    }
}
