<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany, HasMany};

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    //protected $fillable = ['invoice_no', 'create_date', 'due_date', 'notes', 'customer_id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    /**
     *  Products Relations Definition
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     *  Taxes Realation Definition
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function taxes(): BelongsToMany
    {
        return $this->belongsToMany(Tax::class);
    }
}