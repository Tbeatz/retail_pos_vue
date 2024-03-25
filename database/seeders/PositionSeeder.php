<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Position::truncate();
        Schema::enableForeignKeyConstraints();

        Position::create([
            'id' => 1,
            'name' => 'Super Admin',
        ]);

        Position::create([
            'id' => 2,
            'name' => 'Admin',
        ]);
    }
}
