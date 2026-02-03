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
            $table->decimal('latitude', 10, 8)->nullable()->after('address');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            $table->string('city', 100)->nullable()->after('longitude');
            $table->string('state', 100)->nullable()->after('city');
            $table->string('country', 100)->nullable()->after('state');
            $table->string('postal_code', 20)->nullable()->after('country');
            $table->json('amenities')->nullable()->after('postal_code');
            $table->text('directions')->nullable()->after('amenities');
            $table->string('website')->nullable()->after('directions');
            $table->string('phone', 20)->nullable()->after('website');
            $table->boolean('is_verified')->default(false)->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('venues', function (Blueprint $table) {
            $table->dropColumn([
                'latitude',
                'longitude', 
                'city',
                'state',
                'country',
                'postal_code',
                'amenities',
                'directions',
                'website',
                'phone',
                'is_verified'
            ]);
        });
    }
};
