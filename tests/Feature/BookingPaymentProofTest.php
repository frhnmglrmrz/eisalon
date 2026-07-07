<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Service;
use App\Models\Slot;
use App\Models\Stylist;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BookingPaymentProofTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that guests cannot access the booking page or submit bookings.
     */
    public function test_guests_cannot_book()
    {
        // Accessing the booking form
        $response = $this->get('/reservasi');
        $response->assertRedirect('/login');

        // Submitting a booking
        $response = $this->post('/reservasi', []);
        $response->assertRedirect('/login');
    }

    /**
     * Test that authenticated users can book by uploading a payment proof.
     */
    public function test_authenticated_users_can_book_with_payment_proof()
    {
        Storage::fake('public');

        // Create required data
        $user = User::factory()->create(['role' => 'customer']);
        $service = Service::create([
            'name' => 'Haircut',
            'category' => 'Potong',
            'description' => 'Haircut service',
            'price' => 50000.00,
            'duration_minutes' => 30,
            'is_active' => true,
        ]);
        $stylist = Stylist::create([
            'name' => 'John Doe',
            'specialization' => 'Potong',
            'is_available' => true,
        ]);
        $slot = Slot::create([
            'date' => now()->format('Y-m-d'),
            'start_time' => '09:00:00',
            'end_time' => '10:00:00',
            'is_available' => true,
        ]);

        // Access the booking form as user
        $response = $this->actingAs($user)->get('/reservasi');
        $response->assertStatus(200);

        // Submit the booking with a fake file upload
        $file = UploadedFile::fake()->image('payment.jpg');

        $response = $this->actingAs($user)->post('/reservasi', [
            'service_id' => $service->id,
            'date' => now()->format('Y-m-d'),
            'slot_id' => $slot->id,
            'stylist_id' => $stylist->id,
            'notes' => 'Some test notes',
            'payment_proof' => $file,
        ]);

        $response->assertSessionHasNoErrors();

        // Assert redirect to success page
        $booking = Booking::first();
        $this->assertNotNull($booking);
        $response->assertRedirect(route('booking.success', $booking));

        // Assert booking details
        $this->assertEquals($user->id, $booking->user_id);
        $this->assertEquals('pending', $booking->status);
        $this->assertNotNull($booking->payment_proof);

        // Assert file exists in storage
        Storage::disk('public')->assertExists($booking->payment_proof);
    }
}
