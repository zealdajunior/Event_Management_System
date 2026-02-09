<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add QR code and payment tracking to tickets
        Schema::table('tickets', function (Blueprint $table) {
            $table->string('qr_code')->nullable()->unique()->after('quantity');
            $table->string('ticket_number')->nullable()->unique()->after('qr_code');
            $table->enum('status', ['pending', 'confirmed', 'used', 'cancelled'])->default('pending')->after('ticket_number');
            $table->foreignId('payment_id')->nullable()->constrained()->onDelete('set null')->after('status');
            $table->timestamp('check_in_at')->nullable()->after('payment_id');
            $table->foreignId('checked_in_by')->nullable()->constrained('users')->onDelete('set null')->after('check_in_at');
        });

        // Add revenue sharing columns to events table
        Schema::table('events', function (Blueprint $table) {
            $table->decimal('platform_fee_percentage', 5, 2)->default(10.00)->after('price'); // 10% default
            $table->decimal('total_revenue', 10, 2)->default(0)->after('platform_fee_percentage');
            $table->decimal('platform_revenue', 10, 2)->default(0)->after('total_revenue');
            $table->decimal('organizer_revenue', 10, 2)->default(0)->after('platform_revenue');
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending')->after('status');
            $table->text('rejection_reason')->nullable()->after('approval_status');
            $table->timestamp('approved_at')->nullable()->after('rejection_reason');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null')->after('approved_at');
        });

        // Add identity verification to users table
        Schema::table('users', function (Blueprint $table) {
            $table->enum('verification_status', ['unverified', 'pending', 'verified', 'rejected'])->default('unverified')->after('email_verified_at');
            $table->string('id_document_path')->nullable()->after('verification_status');
            $table->string('id_number')->nullable()->after('id_document_path');
            $table->string('phone_number')->nullable()->after('id_number');
            $table->text('verification_notes')->nullable()->after('phone_number');
            $table->timestamp('verified_at')->nullable()->after('verification_notes');
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null')->after('verified_at');
            $table->decimal('balance', 10, 2)->default(0)->after('verified_by'); // Organizer earnings
        });

        // Create payouts table for organizer withdrawals
        Schema::create('payouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->string('payment_method')->nullable(); // bank_transfer, paypal, stripe
            $table->json('payment_details')->nullable(); // Account details
            $table->string('transaction_reference')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        // Create event verification documents table
        Schema::create('event_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('document_type'); // venue_contract, permit, insurance, etc.
            $table->string('document_path');
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('reviewer_notes')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_verifications');
        Schema::dropIfExists('payouts');
        
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropColumn([
                'verification_status',
                'id_document_path',
                'id_number',
                'phone_number',
                'verification_notes',
                'verified_at',
                'verified_by',
                'balance'
            ]);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn([
                'platform_fee_percentage',
                'total_revenue',
                'platform_revenue',
                'organizer_revenue',
                'approval_status',
                'rejection_reason',
                'approved_at',
                'approved_by'
            ]);
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['payment_id', 'checked_in_by']);
            $table->dropColumn([
                'qr_code',
                'ticket_number',
                'status',
                'payment_id',
                'check_in_at',
                'checked_in_by'
            ]);
        });
    }
};
