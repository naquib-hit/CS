<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{ Model, SoftDeletes };
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sales extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['sales_code', 'sales_name', 'sales_email'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
