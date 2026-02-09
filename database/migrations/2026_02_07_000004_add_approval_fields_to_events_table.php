<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (!Schema::hasColumn('events', 'approval_status')) {
                $table->string('approval_status')->default('pending')->after('status'); // pending, approved, rejected
            }
            if (!Schema::hasColumn('events', 'approved_by')) {
                $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete()->after('approval_status');
            }
            if (!Schema::hasColumn('events', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('approved_by');
            }
            if (!Schema::hasColumn('events', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable()->after('approved_at');
            }
            if (!Schema::hasColumn('events', 'requires_approval')) {
                $table->boolean('requires_approval')->default(true)->after('rejection_reason');
            }
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn([
                'approval_status',
                'approved_by',
                'approved_at',
                'rejection_reason',
                'requires_approval'
            ]);
        });
    }
};
