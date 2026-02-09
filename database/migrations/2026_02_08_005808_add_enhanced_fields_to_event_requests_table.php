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
        Schema::table('event_requests', function (Blueprint $table) {
            $table->text('summary')->nullable()->after('event_description');
            $table->enum('event_format', ['physical', 'online', 'hybrid'])->default('physical')->after('end_date');
            $table->decimal('latitude', 10, 8)->nullable()->after('venue');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            $table->string('country_code', 2)->nullable()->after('longitude');
            $table->string('venue_name')->nullable()->after('country_code');
            $table->string('room_details')->nullable()->after('venue_name');
            $table->string('online_event_link', 500)->nullable()->after('room_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_requests', function (Blueprint $table) {
            $table->dropColumn([
                'summary',
                'event_format',
                'latitude',
                'longitude',
                'country_code',
                'venue_name',
                'room_details',
                'online_event_link'
            ]);
        });
    }
};
