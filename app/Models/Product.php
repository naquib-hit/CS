<?php

namespace App\Models;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\{ BelongsTo, HasMany };
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{ Model, SoftDeletes };

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [ 'product_name', 'product_price'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    
    /**
     * productUnit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productUnit(): BelongsTo 
    {
        return $this->belongsTo(ProductUnit::class, 'product_unit_id', 'id');
    }
    
    /**
     * transactions foreign definition
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
    
    /**
     * Get All Data
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public static function getData(): \Illuminate\Database\Query\Builder
    {
        $ret = DB::table('products')
                    ->join('product_units', 'product_units.id', '=', 'products.product_unit_id')
                    ->whereNull('deleted_at');
        return $ret;
    }
}
