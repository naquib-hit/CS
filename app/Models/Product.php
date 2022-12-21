<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{ Model, SoftDeletes };
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [ 'product_name', 'product_price'];
}
