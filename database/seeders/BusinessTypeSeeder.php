<?php

namespace Database\Seeders;

use App\Models\BusinessType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class BusinessTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        BusinessType::truncate();
        Schema::enableForeignKeyConstraints();

        BusinessType::create([
            'id' => 1,
            'name' => 'City Mart',
        ]);

        BusinessType::create([
            'id' => 2,
            'name' => 'One Stop Mart',
        ]);
    }
}
