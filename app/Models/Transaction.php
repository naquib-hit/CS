<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{ Model, SoftDeletes };

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'transation_code',
        'sales_name',
        'start_date',
        'expiration_date',
    ];

    protected $hidden = [
        'customer_id',
        'product_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
