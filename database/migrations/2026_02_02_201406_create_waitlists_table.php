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
        Schema::create('waitlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('ticket_id')->nullable()->constrained()->onDelete('cascade'); // Specific ticket type
            $table->integer('quantity')->default(1); // Number of tickets wanted
            $table->integer('position')->default(0); // Position in waitlist
            $table->enum('status', ['waiting', 'notified', 'expired', 'converted'])->default('waiting');
            $table->timestamp('notified_at')->nullable(); // When user was notified
            $table->timestamp('expires_at')->nullable(); // When notification expires
            $table->text('notification_preferences')->nullable(); // Email, SMS, etc.
            $table->timestamps();
            
            // Ensure one waitlist entry per user per event
            $table->unique(['user_id', 'event_id', 'ticket_id']);
            
            // Index for efficient position queries
            $table->index(['event_id', 'position']);
            $table->index(['status', 'expires_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waitlists');
    }
};
