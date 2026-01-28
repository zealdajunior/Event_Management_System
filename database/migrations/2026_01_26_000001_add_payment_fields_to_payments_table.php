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
            // Add new columns for payment tracking
            if (!Schema::hasColumn('payments', 'transaction_id')) {
                $table->string('transaction_id')->nullable()->unique()->after('payment_method');
            }

            if (!Schema::hasColumn('payments', 'status')) {
                $table->string('status')->default('pending')->after('transaction_id');
            }

            if (!Schema::hasColumn('payments', 'metadata')) {
                $table->json('metadata')->nullable()->after('status');
            }

            if (!Schema::hasColumn('payments', 'refunded_at')) {
                $table->timestamp('refunded_at')->nullable()->after('metadata');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn([
                'transaction_id',
                'status',
                'metadata',
                'refunded_at',
            ]);
        });
    }
};
