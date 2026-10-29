<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(['username' => 'admin_kantin'], ['password' => 'admin123', 'role' => 'admin']);
        User::updateOrCreate(['username' => 'budi_siswa'], ['password' => '123', 'role' => 'siswa']);
    }
}