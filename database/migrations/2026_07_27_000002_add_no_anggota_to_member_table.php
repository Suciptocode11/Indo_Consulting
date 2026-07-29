<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('member', function (Blueprint $table) {
            $table->string('no_anggota')->nullable()->after('id_group');
        });
    }

    public function down(): void
    {
        Schema::table('member', function (Blueprint $table) {
            $table->dropColumn('no_anggota');
        });
    }
};