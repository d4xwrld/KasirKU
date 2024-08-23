<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $table = 'transactions_detail';
    protected $fillable = ['product_id', 'qty', 'price', 'subtotal'];

    protected static function booted()
    {
        static::saving(function ($transactionDetail) {
            $transactionDetail->subtotal = $transactionDetail->qty * $transactionDetail->price;
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}