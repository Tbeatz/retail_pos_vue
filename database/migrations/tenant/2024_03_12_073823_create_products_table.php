<?php

use App\Models\Business;
use App\Models\Category;
use App\Models\CurrencyType;
use App\Models\DiscountType;
use App\Models\Unit;
use App\Models\User;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('name');
            $table->foreignIdFor(Unit::class)->nullable()->constrained()->nullOnDelete();
            $table->text('product_code')->nullable();
            $table->foreignIdFor(Category::class)->nullable()->constrained()->nullOnDelete();
            $table->text('description')->nullable();
            $table->float('price');
            $table->integer('instock_qty')->default(0);
            $table->integer('restock_qty')->nullable();
            $table->foreignIdFor(Business::class)->constrained()->cascadeOnDelete();
            $table->float('discount_price')->nullable()->default(0);
            $table->foreignIdFor(User::class)->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
