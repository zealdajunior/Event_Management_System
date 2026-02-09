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
            // Check if columns exist before adding them
            if (!Schema::hasColumn('event_requests', 'description')) {
                $table->text('description')->nullable()->after('summary');
            }
            if (!Schema::hasColumn('event_requests', 'date')) {
                $table->datetime('date')->nullable()->after('description');
            }
            if (!Schema::hasColumn('event_requests', 'location')) {
                $table->string('location')->nullable()->after('event_format');
            }
            if (!Schema::hasColumn('event_requests', 'capacity')) {
                $table->integer('capacity')->nullable()->after('online_event_link');
            }
            if (!Schema::hasColumn('event_requests', 'price')) {
                $table->decimal('price', 10, 2)->nullable()->after('capacity');
            }
            if (!Schema::hasColumn('event_requests', 'event_type')) {
                $table->string('event_type')->nullable()->after('price');
            }
            if (!Schema::hasColumn('event_requests', 'organizer_name')) {
                $table->string('organizer_name')->nullable()->after('event_type');
            }
            if (!Schema::hasColumn('event_requests', 'organizer_email')) {
                $table->string('organizer_email')->nullable()->after('organizer_name');
            }
            if (!Schema::hasColumn('event_requests', 'organizer_phone')) {
                $table->string('organizer_phone')->nullable()->after('organizer_email');
            }
            if (!Schema::hasColumn('event_requests', 'terms')) {
                $table->text('terms')->nullable()->after('organizer_phone');
            }
            if (!Schema::hasColumn('event_requests', 'cancellation_policy')) {
                $table->text('cancellation_policy')->nullable()->after('terms');
            }
        });
        
        // Try to add foreign key if it doesn't exist
        try {
            Schema::table('event_requests', function (Blueprint $table) {
                $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            });
        } catch (\Exception $e) {
            // Foreign key already exists, ignore
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_requests', function (Blueprint $table) {
            if (Schema::hasColumn('event_requests', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('event_requests', 'date')) {
                $table->dropColumn('date');
            }
            if (Schema::hasColumn('event_requests', 'location')) {
                $table->dropColumn('location');
            }
            if (Schema::hasColumn('event_requests', 'capacity')) {
                $table->dropColumn('capacity');
            }
            if (Schema::hasColumn('event_requests', 'price')) {
                $table->dropColumn('price');
            }
            if (Schema::hasColumn('event_requests', 'event_type')) {
                $table->dropColumn('event_type');
            }
            if (Schema::hasColumn('event_requests', 'organizer_name')) {
                $table->dropColumn('organizer_name');
            }
            if (Schema::hasColumn('event_requests', 'organizer_email')) {
                $table->dropColumn('organizer_email');
            }
            if (Schema::hasColumn('event_requests', 'organizer_phone')) {
                $table->dropColumn('organizer_phone');
            }
            if (Schema::hasColumn('event_requests', 'terms')) {
                $table->dropColumn('terms');
            }
            if (Schema::hasColumn('event_requests', 'cancellation_policy')) {
                $table->dropColumn('cancellation_policy');
            }
        });
    }
};
