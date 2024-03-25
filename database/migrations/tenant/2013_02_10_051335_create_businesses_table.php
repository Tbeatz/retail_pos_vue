<?php

use App\Models\BusinessType;
use App\Models\CurrencyType;
use App\Models\TaxType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(BusinessType::class)->nullable()->constrained()->nullOnDelete();
            $table->text('address');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->foreignIdFor(CurrencyType::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(TaxType::class)->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
