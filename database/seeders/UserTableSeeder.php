<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Fredual Guevara',
            'email' => 'fredual16@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'), // password
            'cedula' => '1007029209',
            'address' => 'Calle 48 23 27',
            'phone' => '3186235419',
            'role' => 'admin',
        ]);
        User::factory()->count(100)->create();
    }
}
