<?php

use App\Models\Business;
use App\Models\InvoiceStatus;
use App\Models\InvoiceType;
use App\Models\PurchaseOrder;
use App\Models\Transaction;
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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Transaction::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(PurchaseOrder::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(InvoiceStatus::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(InvoiceType::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Business::class)->nullable()->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
