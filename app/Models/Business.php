<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    public function business_type(){
        return $this->belongsTo(BusinessType::class);
    }

    public function currency_type(){
        return $this->belongsTo(CurrencyType::class);
    }

    public function tax_type(){
        return $this->belongsTo(TaxType::class);
    }
}
