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
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'booking_id')) {
                $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            }
            if (!Schema::hasColumn('payments', 'amount')) {
                $table->decimal('amount', 10, 2);
            }
            if (!Schema::hasColumn('payments', 'payment_method')) {
                $table->string('payment_method');
            }
            if (!Schema::hasColumn('payments', 'payment_date')) {
                $table->date('payment_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['booking_id']);
            $table->dropColumn(['booking_id', 'amount', 'payment_method', 'payment_date']);
        });
    }
};
