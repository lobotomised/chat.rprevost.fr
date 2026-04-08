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
        Schema::create('domologs', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('model')->nullable();
            $table->string('message');
            $table->json('context');
            $table->uuid('trace')->nullable();
            $table->string('user');
            $table->text('stack_trace');
            $table->string('method');
            $table->string('request_uri');
            $table->string('referer');
            $table->ipAddress('ip');
            $table->timestamps();

            $table->index('created_at');
            $table->index(['trace', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domologs');
    }
};
