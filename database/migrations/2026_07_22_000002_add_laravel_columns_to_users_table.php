<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cek apakah tabel users sudah ada (dari SQL dump)
        if (!Schema::hasTable('users')) {
            // Buat tabel users dari nol
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('username', 100);
                $table->string('email')->unique();
                $table->string('password');
                $table->rememberToken();
                $table->string('nama');
                $table->string('level', 50);
                $table->timestamps();
            });
        } else {
            // Tabel sudah ada (dari SQL dump) — tambah kolom Laravel
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'email')) {
                    $table->string('email')->unique()->after('username');
                }
                if (!Schema::hasColumn('users', 'remember_token')) {
                    $table->rememberToken()->after('password');
                }
                if (!Schema::hasColumn('users', 'created_at')) {
                    $table->timestamps();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['email', 'remember_token', 'created_at', 'updated_at']);
            });
        }
    }
};
