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
        Schema::table('venues', function (Blueprint $table) {
            if (!Schema::hasColumn('venues', 'country_code')) {
                $table->string('country_code', 2)->nullable()->after('country');
            }
        });
        
        Schema::table('events', function (Blueprint $table) {
            if (!Schema::hasColumn('events', 'country_code')) {
                $table->string('country_code', 2)->nullable()->after('location');
            }
            if (!Schema::hasColumn('events', 'city')) {
                $table->string('city')->nullable()->after('location');
            }
            if (!Schema::hasColumn('events', 'country')) {
                $table->string('country')->nullable()->after('city');
            }
            if (!Schema::hasColumn('events', 'venue_name')) {
                $table->string('venue_name')->nullable()->after('venue_id');
            }
            if (!Schema::hasColumn('events', 'room_details')) {
                $table->string('room_details')->nullable()->after('venue_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('venues', function (Blueprint $table) {
            $table->dropColumn('country_code');
        });
        
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['country_code', 'city', 'country', 'venue_name', 'room_details']);
        });
    }
};
