<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Constructor removed as auth middleware is handled in routes

    /**
     * Store a new review
     */
    public function store(Request $request, Booking $booking)
    {
        // Ensure user owns this booking
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        // Ensure booking is completed
        if ($booking->status !== 'completed') {
            return back()->withErrors([
                'review' => 'You can only review completed bookings'
            ]);
        }

        // Ensure no existing review
        if ($booking->review) {
            return back()->withErrors([
                'review' => 'You have already reviewed this booking'
            ]);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'booking_id' => $booking->id,
            'service_id' => $booking->service_id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Thank you for your review!');
    }

    /**
     * Update the review
     */
    public function update(Request $request, Review $review)
    {
        // Ensure user owns this review
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review->update($validated);

        return back()->with('success', 'Review updated successfully!');
    }

    /**
     * Delete the review
     */
    public function destroy(Review $review)
    {
        // Ensure user owns this review
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $review->delete();

        return back()->with('success', 'Review deleted successfully!');
    }
}
