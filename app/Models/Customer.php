<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{ Model, SoftDeletes };

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['customer_name', 'customer_address', 'customer_email', 'customer_phone'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function transactions() 
    {
        return $this->hasMany(Transaction::class);
    }
}
