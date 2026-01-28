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
        // Add super_admin flag to users table
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_super_admin')->default(false)->after('role');
        });

        // Add verification fields to event_requests table
        Schema::table('event_requests', function (Blueprint $table) {
            $table->timestamp('email_verified_at')->nullable()->after('status');
            $table->timestamp('phone_verified_at')->nullable()->after('email_verified_at');
            $table->json('verification_documents')->nullable()->after('phone_verified_at');
            $table->string('verification_status')->default('pending')->after('verification_documents'); // pending, verified, rejected
            $table->text('verification_notes')->nullable()->after('verification_status');
            $table->integer('risk_score')->default(0)->after('verification_notes');
            $table->string('organization_registration_number')->nullable()->after('risk_score');
            $table->string('organizer_id_number')->nullable()->after('organization_registration_number');
            $table->string('organizer_id_document')->nullable()->after('organizer_id_number');
            $table->string('event_permit_document')->nullable()->after('organizer_id_document');
            $table->string('venue_booking_document')->nullable()->after('event_permit_document');
            $table->text('social_media_links')->nullable()->after('venue_booking_document');
            $table->unsignedBigInteger('verified_by')->nullable()->after('social_media_links');
            $table->timestamp('verified_at')->nullable()->after('verified_by');
            
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_super_admin');
        });

        Schema::table('event_requests', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropColumn([
                'email_verified_at',
                'phone_verified_at',
                'verification_documents',
                'verification_status',
                'verification_notes',
                'risk_score',
                'organization_registration_number',
                'organizer_id_number',
                'organizer_id_document',
                'event_permit_document',
                'venue_booking_document',
                'social_media_links',
                'verified_by',
                'verified_at'
            ]);
        });
    }
};
