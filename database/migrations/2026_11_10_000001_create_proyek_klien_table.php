<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proyek_klien', function (Blueprint $table) {
            $table->id();
            $table->string('kode_proyek', 30)->unique();
            $table->string('nama_proyek', 255);
            $table->string('nama_klien', 255);
            $table->string('kontak_klien', 255)->nullable();
            $table->unsignedInteger('service_id')->nullable();
            $table->foreign('service_id')->references('id')->on('service')->nullOnDelete();
            $table->decimal('nilai_kontrak', 18, 2)->default(0);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->enum('status', ['berjalan', 'selesai', 'pending', 'batal'])->default('berjalan');
            $table->text('keterangan')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::table('transaksi_keuangan', function (Blueprint $table) {
            $table->unsignedBigInteger('proyek_klien_id')->nullable()->after('service_id');
            $table->foreign('proyek_klien_id')->references('id')->on('proyek_klien')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('transaksi_keuangan', function (Blueprint $table) {
            $table->dropForeign(['proyek_klien_id']);
            $table->dropColumn('proyek_klien_id');
        });

        Schema::dropIfExists('proyek_klien');
    }
};

