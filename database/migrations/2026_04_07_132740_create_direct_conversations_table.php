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
        Schema::create('direct_conversations', function (Blueprint $table) {
            $table->unsignedBigInteger('conversation_id')->primary();
            $table->unsignedBigInteger('user_low_id');
            $table->unsignedBigInteger('user_high_id');
            $table->timestamps();

            $table->foreign('conversation_id')->references('id')->on('conversations')->cascadeOnDelete();
            $table->foreign('user_low_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('user_high_id')->references('id')->on('users')->cascadeOnDelete();

            $table->unique(['user_low_id', 'user_high_id']);
            $table->index(['user_low_id']);
            $table->index(['user_high_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direct_conversations');
    }
};
