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
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('booking_reference', 20)->unique()->nullable()->after('id');
            $table->foreignId('payment_id')->nullable()->after('status')->constrained('payments')->nullOnDelete();
        });

        // Generate references for existing bookings
        \DB::table('bookings')->whereNull('booking_reference')->get()->each(function($booking) {
            \DB::table('bookings')
                ->where('id', $booking->id)
                ->update([
                    'booking_reference' => 'BKG' . str_pad($booking->id, 8, '0', STR_PAD_LEFT) . strtoupper(substr(md5($booking->id . time()), 0, 4))
                ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['payment_id']);
            $table->dropColumn(['booking_reference', 'payment_id']);
        });
    }
};
