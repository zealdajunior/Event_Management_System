<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('session_id')->index(); // For guest users
            $table->enum('role', ['user', 'assistant', 'system'])->default('user');
            $table->text('message');
            $table->json('context')->nullable(); // Store location, filters, etc.
            $table->json('suggested_events')->nullable(); // AI suggested event IDs
            $table->string('intent')->nullable(); // search, question, booking, etc.
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamps();

            $table->index(['session_id', 'created_at']);
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
