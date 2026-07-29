<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->string('foto')->nullable();
            $table->string('nama');
            $table->string('email');
            $table->string('telepon')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kode_provinsi')->nullable();
            $table->text('alamat')->nullable();
            $table->string('daerah_asal')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('institusi')->nullable();
            $table->string('pengalaman')->nullable();
            $table->text('keahlian')->nullable();
            $table->string('posisi')->nullable();
            $table->text('surat_motivasi')->nullable();
            $table->string('cv')->nullable();
            $table->string('status')->default('Pending');
            $table->string('no_anggota')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};
