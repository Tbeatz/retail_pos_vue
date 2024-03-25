<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function payment_method(){
        return $this->belongsTo(PaymentMethod::class);
    }

    public function sales(){
        return $this->hasMany(Sale::class);
    }
}
