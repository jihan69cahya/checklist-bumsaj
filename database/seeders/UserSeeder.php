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
            [
                'name' => 'user checklist',
                'email' => 'user@gmail.com',
                'password' => Hash::make('us3r'),
                'role' => 'USER',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'admin validator',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('4dm1n'),
                'role' => 'ADMIN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
