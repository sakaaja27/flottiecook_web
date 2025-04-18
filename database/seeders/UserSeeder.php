<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'DevOps',
            'email' => 'devops@mail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'phone' => '1234567890',
        ]);
    }
}
