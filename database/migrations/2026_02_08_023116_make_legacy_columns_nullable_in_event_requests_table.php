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
            // Make old columns nullable to support new form structure
            $table->string('event_title')->nullable()->change();
            $table->text('event_description')->nullable()->change();
            $table->datetime('start_date')->nullable()->change();
            $table->datetime('end_date')->nullable()->change();
            $table->string('venue')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_requests', function (Blueprint $table) {
            // Revert to required (won't work if there are null values)
            $table->string('event_title')->nullable(false)->change();
            $table->text('event_description')->nullable(false)->change();
            $table->datetime('start_date')->nullable(false)->change();
            $table->datetime('end_date')->nullable(false)->change();
            $table->string('venue')->nullable(false)->change();
        });
    }
};
