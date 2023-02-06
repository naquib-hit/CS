<?php

namespace App\Models;

use App\Traits\UUIDTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory, UUIDTrait;

    /**
     * guarded props
     *
     * @var array
     */
    protected $guarded = ['id'];

    public static function getByProducts() 
    {
       $stmt = "SELECT obj -> 'id' as product_id, obj -> 'product_name' as product_name, obj -> 'pivot' -> 'total_price' as product_price
                FROM 
                (SELECT r.id, obj FROM reports r, json_array_elements(r.deskripsi#>'{products}') obj) products"; 

       $reports = collect(DB::select($stmt))
                    ->sortBy('product_id')
                    ->groupBy('product_id')
                    ->tap(function($coll) {
                        $coll->each(function($q) {
                            $red = array_reduce($q->toArray(), function($sum, $val) {
                                $sum += intval($val['product_price']);
                            });

                            $q->put('total_price', $red);
                        });
                    })
                    ->toArray();
       return $reports;
    }

    public function getByCustomers() {

    }

}
