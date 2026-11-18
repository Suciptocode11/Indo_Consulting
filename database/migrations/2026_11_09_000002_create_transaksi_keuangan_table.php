<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_keuangan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi', 30)->unique();
            $table->date('tanggal');
            $table->enum('tipe', ['pemasukan', 'pengeluaran']);
            $table->unsignedBigInteger('kategori_id');
            $table->foreign('kategori_id')->references('id')->on('kategori_keuangan')->restrictOnDelete();
            $table->unsignedInteger('service_id')->nullable();
            $table->foreign('service_id')->references('id')->on('service')->nullOnDelete();
            $table->string('judul', 500);
            $table->decimal('nominal', 18, 2);
            $table->enum('metode_pembayaran', ['Transfer Bank', 'Kas Tunai', 'Lainnya'])->default('Transfer Bank');
            $table->enum('status', ['lunas', 'pending'])->default('pending');
            $table->string('bukti', 500)->nullable();
            $table->text('keterangan')->nullable();
            $table->unsignedInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_keuangan');
    }
};
