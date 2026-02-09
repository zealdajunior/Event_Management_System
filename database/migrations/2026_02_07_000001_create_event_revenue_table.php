<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_revenue', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('payment_id')->constrained()->onDelete('cascade');
            $table->decimal('total_amount', 10, 2); // Total ticket price
            $table->decimal('platform_fee', 10, 2); // Platform commission (e.g., 10%)
            $table->decimal('organizer_earnings', 10, 2); // Amount for event organizer
            $table->decimal('platform_fee_percentage', 5, 2)->default(10.00); // % taken by platform
            $table->string('status')->default('pending'); // pending, available, paid
            $table->timestamp('available_at')->nullable(); // When funds become available (e.g., after event)
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index(['event_id', 'status']);
            $table->index('available_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_revenue');
    }
};
