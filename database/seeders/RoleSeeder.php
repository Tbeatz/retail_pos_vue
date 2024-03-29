<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Role::truncate();
        Schema::enableForeignKeyConstraints();

        Role::create([
            'id' => 1,
            'name' => 'Owner',
        ]);

        Role::create([
            'id' => 2,
            'name' => 'Admin',
        ]);

        Role::create([
            'id' => 3,
            'name' => 'User',
        ]);
    }
}
