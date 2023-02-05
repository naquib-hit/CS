<?php

namespace App\Models;

use App\Traits\UUIDTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Transaction extends Model
{
    use HasFactory, SoftDeletes, UUIDTrait;


    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $guarded = ['id'];



    public function getByProducts(\DateTime $from, \DateTime $to) {
        $return = DB::table('transaction')
                    ->select(DB::raw('details->products->id as product_id, details->products->product_name, SUM()'))
                    ->join('invoice_product', 'invoice_product.invoice_id=details->id')
                    ->groupBy('products.id', 'products.product_name');
        return $return;
    }

}