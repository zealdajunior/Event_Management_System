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
        Schema::table('events', function (Blueprint $table) {
            // Add missing columns from the enhanced admin form
            if (!Schema::hasColumn('events', 'summary')) {
                $table->string('summary', 200)->nullable()->after('name');
            }
            if (!Schema::hasColumn('events', 'latitude')) {
                $table->decimal('latitude', 10, 8)->nullable()->after('location');
            }
            if (!Schema::hasColumn('events', 'longitude')) {
                $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            }
            if (!Schema::hasColumn('events', 'event_format')) {
                $table->string('event_format')->nullable()->after('event_type'); // physical, online, hybrid
            }
            if (!Schema::hasColumn('events', 'online_event_link')) {
                $table->string('online_event_link')->nullable()->after('event_format');
            }
            if (!Schema::hasColumn('events', 'terms')) {
                $table->text('terms')->nullable()->after('additional_info');
            }
            if (!Schema::hasColumn('events', 'cancellation_policy')) {
                $table->text('cancellation_policy')->nullable()->after('terms');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn([
                'summary',
                'latitude',
                'longitude',
                'event_format',
                'online_event_link',
                'terms',
                'cancellation_policy',
            ]);
        });
    }
};
