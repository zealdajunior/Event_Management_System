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
            $table->integer('capacity')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->string('category')->nullable();
            $table->json('tags')->nullable();
            $table->string('image')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->text('agenda')->nullable();
            $table->string('organizer_name')->nullable();
            $table->string('organizer_email')->nullable();
            $table->string('organizer_phone')->nullable();
            $table->text('requirements')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('allow_registrations')->default(true);
            $table->string('registration_deadline')->nullable();
            $table->text('additional_info')->nullable();
            $table->string('event_type')->nullable();
            $table->integer('min_age')->nullable();
            $table->integer('max_age')->nullable();
            $table->string('language')->nullable();
            $table->text('accessibility_info')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('website')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn([
                'capacity', 'price', 'category', 'tags', 'image', 'end_date', 'agenda',
                'organizer_name', 'organizer_email', 'organizer_phone', 'requirements',
                'is_featured', 'allow_registrations', 'registration_deadline', 'additional_info',
                'event_type', 'min_age', 'max_age', 'language', 'accessibility_info',
                'contact_person', 'website'
            ]);
        });
    }
};
