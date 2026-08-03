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
        Schema::create('bookings', function (Blueprint $table) {

            $table->uuid('id')->primary()->unique()->index();

            // $table->foreignId('room_id')
            //     ->constrained()
            //     ->cascadeOnDelete();

            // $table->foreignId('user_id')
            //     ->constrained()
            //     ->cascadeOnDelete();

            $table->foreignUuid('room_id')->index('booking_to_room')
                ->constrained('rooms', 'id', 'jadwal_to_rab')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignUuid('user_id')->index('booking_to_user')
                ->constrained('users', 'id', 'jadwal_to_user')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();


            $table->date('booking_date');

            $table->time('start_time');

            $table->time('end_time');

            $table->string('purpose');

            $table->enum('status', [
                'Menunggu',
                'Disetujui',
                'Ditolak',
                'Selesai'
            ])->default('Menunggu');

            // $table->foreignId('approved_by')
            //     ->nullable()
            //     ->constrained('users')
            //     ->nullOnDelete();
            $table->foreignUuid('approved_by')->index('approved_by_to_user')
                ->constrained('users', 'id', 'approved_by_to_user')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();


            $table->timestamp('approved_at')->nullable();

            $table->text('rejection_reason')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
