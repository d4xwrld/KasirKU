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
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@localhost.test',
            'usertype' => 'admin',
            'password' => bcrypt('admin12345'),
        ]);
        User::factory()->create([
            'name' => 'Kasir',
            'email' => 'kasir@localhost.test',
            'usertype' => 'kasir',
            'password' => bcrypt('kasir12345'),
        ]);
    }
}