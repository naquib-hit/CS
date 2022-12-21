<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{ Model, SoftDeletes };

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['customer_name', 'customer_address', 'customer_email', 'customer_phone'];
}
