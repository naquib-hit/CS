<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{ Model, SoftDeletes };

class Transaction extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'transation_code',
        'start_date',
        'expiration_date',
        'customer_id',
        'product_id',
        'sales_id'
    ];

    protected $hidden = [ 'created_at', 'updated_at', 'deleted_at' ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    // public function sales(): BelongsTo
    // {
    //     return $this->belongsTo(Sales::class, 'sales_id', 'id');
    // }

    /**
     * Get All Data
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public static function getAll(array $filter = NULL): \Illuminate\Database\Query\Builder
    {
        $trans = DB::table('transactions')
                    ->join('customers', 'customers.id', '=', 'transactions.customer_id')
                    ->join('products', 'products.id', '=', 'transactions.product_id')
                    //->join('sales', 'sales.id', '=', 'transactions.sales_id')
                    ->whereNull('transactions.deleted_at');

        return $trans;
    }
}
