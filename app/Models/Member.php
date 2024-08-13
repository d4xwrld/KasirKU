<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'phone',
    ];

    protected function casts(): array
    {
        return [    
            'name' => 'string',
            'phone' => 'string',
        ];
    }
}