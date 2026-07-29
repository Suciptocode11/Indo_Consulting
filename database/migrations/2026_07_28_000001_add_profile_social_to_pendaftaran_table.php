<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->text('profil_singkat')->nullable()->after('catatan_admin');
            $table->string('link_wa')->nullable()->after('profil_singkat');
            $table->string('link_linkedin')->nullable()->after('link_wa');
            $table->string('link_instagram')->nullable()->after('link_linkedin');
            $table->string('link_facebook')->nullable()->after('link_instagram');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropColumn(['profil_singkat', 'link_wa', 'link_linkedin', 'link_instagram', 'link_facebook']);
        });
    }
};