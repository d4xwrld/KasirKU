<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['member_id', 'total'];

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    protected static function booted()
    {
        static::saving(function ($transaction) {
            $transaction->total = $transaction->transactionDetails->sum('subtotal');
        });
    }
}