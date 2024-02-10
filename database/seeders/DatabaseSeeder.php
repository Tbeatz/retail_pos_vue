<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BusinessTypeSeeder::class,
            RoleSeeder::class,
            PositionSeeder::class,
            BusinessSeeder::class,
            PaymentMethodSeeder::class,
            UnitSeeder::class,
            InvoiceTypeSeeder::class,
            InvoiceStatusSeeder::class,
            DiscountTypeSeeder::class,
            TaxTypeSeeder::class,
            CategorySeeder::class,
            CurrencyTypeSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
