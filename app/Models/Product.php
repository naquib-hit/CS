<?php

namespace App\Models;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\{ BelongsTo, BelongsToMany, HasMany };
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{ Model, SoftDeletes };

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [ 'product_name', 'product_price'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    
    
    /**
     * Transaction table relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * The invoices that belong to the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function invoices(): BelongsToMany
    {
        return $this->belongsToMany(Invoice::class, 'invoice_product', 'product_id', 'invoice_id');
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
