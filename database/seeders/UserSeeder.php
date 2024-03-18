<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        User::create([
            'name' => 'Thu Ta',
            'email' => 'tbeatz.feb@gmail.com',
            'address' => 'Yankin, Yangon, Myanmar',
            'phone' => '09252036776',
            'position_id' => 1,
            'role_id' => 1, //admin
            'approve' => true,
            'password' => Hash::make('123'), 
        ]);
    }
}
