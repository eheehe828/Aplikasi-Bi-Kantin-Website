<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate([
            'email' => 'admin_kantin',
        ], [
            'name' => 'Admin Kantin',
            'role' => 'admin',
            'password' => 'admin123',
        ]);

        User::query()->updateOrCreate([
            'email' => 'budi_siswa',
        ], [
            'name' => 'Budi Siswa',
            'role' => 'siswa',
            'password' => '123',
        ]);
    }
}
