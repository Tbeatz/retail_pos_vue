<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function unit(){
        return $this->belongsTo(Unit::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function business(){
        return $this->belongsTo(Business::class);
    }

    public function discount_type(){
        return $this->belongsTo(DiscountType::class);
    }

    public function currency_type(){
        return $this->belongsTo(CurrencyType::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
