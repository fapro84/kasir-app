<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'nama_user' => 'administrator',
            'username' => 'admin',
            'password' => Hash::make('123'), // Jangan lupa untuk menggunakan Hash::make untuk menyandikan password
            'user_priv' => 'admin',
            'alamat' => 'blaaa',
            'hp' => '0813937057035',
            'status' => 'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
