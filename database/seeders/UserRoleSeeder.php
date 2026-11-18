<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    public function run()
    {
        // 1. Super Admin
        $superAdmin = User::first();
        if ($superAdmin) {
            $superAdmin->level = 'super_admin';
            $superAdmin->save();
        } else {
            User::create([
                'username' => 'admin',
                'email'    => 'admin@indoconsulting.id',
                'nama'     => 'Super Administrator',
                'password' => Hash::make('password123'),
                'level'    => 'super_admin',
            ]);
        }

        // 2. Admin (Semua bisa kecuali keuangan)
        User::updateOrCreate(
            ['username' => 'admin_staff'],
            [
                'email'    => 'staff@indoconsulting.id',
                'nama'     => 'Admin Operasional',
                'password' => Hash::make('password123'),
                'level'    => 'admin',
            ]
        );

        // 3. Finance (Khusus keuangan)
        User::updateOrCreate(
            ['username' => 'finance'],
            [
                'email'    => 'finance@indoconsulting.id',
                'nama'     => 'Staf Keuangan',
                'password' => Hash::make('password123'),
                'level'    => 'finance',
            ]
        );
    }
}

