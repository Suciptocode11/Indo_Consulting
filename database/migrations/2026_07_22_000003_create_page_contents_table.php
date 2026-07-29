<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_contents', function (Blueprint $table) {
            $table->id();
            $table->string('page');          // home, tentang-kami, program, dll
            $table->string('key');  // hero_heading_1, stats_1_number, dll
            $table->unique(['page', 'key']);  // unik per halaman
            $table->text('value')->nullable();
            $table->string('type')->default('text');  // text, image, textarea
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_contents');
    }
};
