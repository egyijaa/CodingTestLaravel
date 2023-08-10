<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        \App\Models\User::factory()->create([
            'name' => 'Egy Ihza Madhani',
            'email' => 'egyijaa@gmail.com',
            'username' => 'egyijaa',
            'password' => Hash::make("P@ssw0rd"),
        ]);
        
        \App\Models\User::factory()->create([
            'name' => 'Superadmin',
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'password' => Hash::make("P@ssw0rd"),
        ]);
    }
}
