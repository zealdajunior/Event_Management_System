<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organizer_payouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Event organizer
            $table->foreignId('event_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('amount', 10, 2);
            $table->string('payment_method')->default('bank_transfer'); // bank_transfer, paypal, stripe
            $table->json('payment_details')->nullable(); // Bank details, PayPal email, etc.
            $table->string('status')->default('pending'); // pending, processing, completed, failed
            $table->text('notes')->nullable();
            $table->string('transaction_reference')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organizer_payouts');
    }
};
