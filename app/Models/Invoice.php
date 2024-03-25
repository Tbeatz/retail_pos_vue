<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    public function transaction(){
        return $this->belongsTo(Transaction::class);
    }

    public function purchase_order(){
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function invoice_status(){
        return $this->belongsTo(InvoiceStatus::class);
    }

    public function invoice_type(){
        return $this->belongsTo(InvoiceType::class);
    }
    
    public function business(){
        return $this->belongsTo(Business::class);
    }
}
