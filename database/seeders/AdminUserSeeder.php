<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        if (!DB::table('users')->where('username', 'admin')->exists()) {
            DB::table('users')->insert([
                'username' => 'admin',
                'email' => 'admin@indoconsulting.id',
                'password' => Hash::make('password'),
                'nama' => 'Administrator',
                'level' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
