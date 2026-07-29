<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_media', function (Blueprint $table) {
            $table->id();
            $table->string('platform');      // instagram, linkedin, facebook, youtube, twitter, whatsapp
            $table->string('url')->nullable();
            $table->string('label')->nullable();  // nama tampilan
            $table->integer('urutan')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_media');
    }
};
