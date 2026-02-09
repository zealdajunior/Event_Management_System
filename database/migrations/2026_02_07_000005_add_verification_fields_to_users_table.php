<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'identity_verified')) {
                $table->boolean('identity_verified')->default(false)->after('email_verified_at');
            }
            if (!Schema::hasColumn('users', 'identity_verified_at')) {
                $table->timestamp('identity_verified_at')->nullable()->after('identity_verified');
            }
            if (!Schema::hasColumn('users', 'phone_number')) {
                $table->string('phone_number')->nullable()->after('identity_verified_at');
            }
            if (!Schema::hasColumn('users', 'phone_verified')) {
                $table->boolean('phone_verified')->default(false)->after('phone_number');
            }
            if (!Schema::hasColumn('users', 'can_organize_events')) {
                $table->boolean('can_organize_events')->default(false)->after('phone_verified');
            }
            if (!Schema::hasColumn('users', 'stripe_account_id')) {
                $table->string('stripe_account_id')->nullable()->after('can_organize_events');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'identity_verified',
                'identity_verified_at',
                'phone_number',
                'phone_verified',
                'can_organize_events',
                'stripe_account_id'
            ]);
        });
    }
};
