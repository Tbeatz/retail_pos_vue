<?php

namespace Database\Seeders;

use App\Models\InvoiceType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class InvoiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        InvoiceType::truncate();
        Schema::enableForeignKeyConstraints();

        InvoiceType::create([
            'id' => 1,
            'name' => 'Customer',
        ]);

        InvoiceType::create([
            'id' => 2,
            'name' => 'Supplier',
        ]);
    }
}
