<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        // 1. Modifikasi tabel services (rename kolom)
        Schema::table('services', function (Blueprint $table) {
            $table->renameColumn('duration', 'duration_minutes');
            $table->renameColumn('image', 'photo');
        });

        // 2. Buat tabel stylists
        Schema::create('stylists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('specialization')->nullable();
            $table->text('bio')->nullable();
            $table->string('photo')->nullable();
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });

        // 3. Buat tabel slots
        Schema::create('slots', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });

        // 4. Drop tabel-tabel lama dari Ei Salon yang tidak diperlukan
        Schema::dropIfExists('payments');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('whatsapp_bookings');
        Schema::dropIfExists('booking_slots');
        Schema::dropIfExists('therapists');
        Schema::dropIfExists('bookings');

        // Buat tabel bookings baru sesuai spesifikasi Alan's Art Hair Salon
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('guest_name')->nullable();
            $table->string('guest_phone')->nullable();
            $table->string('guest_email')->nullable();
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->foreignId('stylist_id')->nullable()->constrained('stylists')->onDelete('set null');
            $table->foreignId('slot_id')->constrained('slots')->onDelete('cascade');
            $table->date('booking_date');
            $table->time('booking_time');
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamp('whatsapp_sent_at')->nullable();
            $table->timestamps();
        });

        // 5. Buat tabel galleries
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->nullable()->constrained('services')->onDelete('set null');
            $table->string('caption')->nullable();
            $table->string('photo');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('galleries');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('slots');
        Schema::dropIfExists('stylists');

        Schema::table('services', function (Blueprint $table) {
            $table->renameColumn('duration_minutes', 'duration');
            $table->renameColumn('photo', 'image');
        });

        Schema::enableForeignKeyConstraints();
    }
};
