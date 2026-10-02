<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@bps.go.id'],
            [
                'name'     => 'admin',
                'password' => Hash::make('password123'),
            ]
        );
        $this->call(AdminUserSeeder::class);
    }
}