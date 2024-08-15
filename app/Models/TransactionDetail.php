<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $table = 'transactions_detail';
    protected $fillable = ['transaction_id', 'product_id', 'member_id', 'qty', 'total'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}