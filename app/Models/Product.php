<?php

namespace App\Models;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{ Model, SoftDeletes };

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [ 'product_name', 'product_price'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function transactions() 
    {
        return $this->hasMany(Transaction::class);
    }
}
