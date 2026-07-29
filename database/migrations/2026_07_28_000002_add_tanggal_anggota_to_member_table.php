<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('member', function (Blueprint $table) {
            $table->date('tanggal_anggota')->nullable()->after('no_anggota');
        });
    }

    public function down(): void
    {
        Schema::table('member', function (Blueprint $table) {
            $table->dropColumn('tanggal_anggota');
        });
    }
};