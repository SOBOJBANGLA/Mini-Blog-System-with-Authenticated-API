<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'User',
            'email' => 'demo@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
