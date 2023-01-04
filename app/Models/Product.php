<?php

namespace App\Models;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{ Model, SoftDeletes };

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [ 'product_name', 'product_price'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function productUnit(): BelongsTo 
    {
        return $this->belongsTo(ProductUnit::class, 'product_unit_id', 'id');
    }

    public function transactions() 
    {
        return $this->hasMany(Transaction::class);
    }

    public static function getData()
    {
        $ret = DB::table('products')
                    ->join('product_units', 'product_units.id', '=', 'products.product_unit_id');
        return $ret;
    }
}
