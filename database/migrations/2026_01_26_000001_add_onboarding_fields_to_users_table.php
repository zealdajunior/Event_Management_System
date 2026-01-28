<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('onboarding_completed')->default(false)->after('role');
            $table->json('interests')->nullable()->after('onboarding_completed');
            $table->string('favorite_event_types')->nullable()->after('interests');
            $table->string('location')->nullable()->after('favorite_event_types');
            $table->string('occupation')->nullable()->after('location');
            $table->date('date_of_birth')->nullable()->after('occupation');
            $table->text('bio')->nullable()->after('date_of_birth');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'onboarding_completed',
                'interests',
                'favorite_event_types',
                'location',
                'occupation',
                'date_of_birth',
                'bio'
            ]);
        });
    }
};
