<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{ Model, SoftDeletes };

class Transaction extends Model
{
    use HasFactory, SoftDeletes;


    protected $hidden = [
        'transation_code',
        'start_date',
        'expiration_date',
        'customer_id',
        'product_id',
        'sales_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function sales(): BelongsTo
    {
        return $this->belongsTo(Sales::class, 'sales_id', 'id');
    }
}
