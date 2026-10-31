<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        if (User::where('email', 'admin@example.com')->exists()) {
            return;
        }

        User::forceCreate([
            'name'     => 'Admin',
            'email'    => 'admin@example.com',
            'password' => 'password123',
            'role'     => 'admin',
        ]);
    }
}
