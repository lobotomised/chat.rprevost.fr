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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('uploader_id');
            $table->string('type', 10); // image|video
            $table->string('path');
            $table->string('thumb_path')->nullable(); // vidéo
            $table->string('mime', 100);
            $table->unsignedBigInteger('size_bytes');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('uploader_id')->references('id')->on('users')->cascadeOnDelete();

            $table->index(['uploader_id', 'created_at']);
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
