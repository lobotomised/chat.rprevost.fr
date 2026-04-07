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
        Schema::create('conversation_participants', function (Blueprint $table) {
            $table->unsignedBigInteger('conversation_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('last_received_message_id')->nullable();
            $table->unsignedBigInteger('last_read_message_id')->nullable();
            $table->timestamps();

            $table->primary(['conversation_id', 'user_id']);

            $table->foreign('conversation_id')->references('id')->on('conversations')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();

            $table->foreign('last_received_message_id')->references('id')->on('messages')->nullOnDelete();
            $table->foreign('last_read_message_id')->references('id')->on('messages')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversation_participants');
    }
};
