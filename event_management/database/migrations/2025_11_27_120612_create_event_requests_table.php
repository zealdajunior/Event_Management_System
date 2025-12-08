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
        Schema::create('event_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('event_title');
            $table->text('event_description');
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->string('venue');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->integer('expected_attendance')->nullable();
            $table->string('event_category')->nullable();
            $table->text('target_audience')->nullable();
            $table->decimal('budget_estimate', 10, 2)->nullable();
            $table->enum('ticket_pricing', ['free', 'paid', 'donation'])->nullable();
            $table->text('special_requirements')->nullable();
            $table->text('marketing_plan')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->text('additional_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_requests');
    }
};
