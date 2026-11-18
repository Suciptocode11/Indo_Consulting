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
        Schema::table('transaksi_keuangan', function (Blueprint $table) {
            if (!Schema::hasColumn('transaksi_keuangan', 'satuan')) {
                $table->string('satuan', 50)->nullable()->default('paket')->after('nominal');
            }
            if (!Schema::hasColumn('transaksi_keuangan', 'volume')) {
                $table->decimal('volume', 10, 2)->default(1)->after('satuan');
            }
            if (!Schema::hasColumn('transaksi_keuangan', 'harga_satuan')) {
                $table->decimal('harga_satuan', 15, 2)->nullable()->after('volume');
            }
            if (!Schema::hasColumn('transaksi_keuangan', 'deskripsi')) {
                $table->text('deskripsi')->nullable()->after('keterangan');
            }
        });

        Schema::table('proyek_klien', function (Blueprint $table) {
            if (!Schema::hasColumn('proyek_klien', 'pic')) {
                $table->string('pic', 100)->nullable()->after('nama_klien');
            }
            if (!Schema::hasColumn('proyek_klien', 'deskripsi')) {
                $table->text('deskripsi')->nullable()->after('keterangan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi_keuangan', function (Blueprint $table) {
            $table->dropColumn(['satuan', 'volume', 'harga_satuan', 'deskripsi']);
        });

        Schema::table('proyek_klien', function (Blueprint $table) {
            $table->dropColumn(['pic', 'deskripsi']);
        });
    }
};
