<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi_keuangan', function (Blueprint $table) {
            // Tambah setelah kolom judul
            $table->string('penerima', 255)->nullable()->after('judul')
                ->comment('Nama vendor/konsultan/penerima uang (untuk pengeluaran)');
        });
    }

    public function down(): void
    {
        Schema::table('transaksi_keuangan', function (Blueprint $table) {
            $table->dropColumn('penerima');
        });
    }
};

