<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductUnit extends Model
{
    use HasFactory;

    protected $fillable = ['unit_name'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function products() 
    {
        return $this->hasMany(Product::class);
    }

}
