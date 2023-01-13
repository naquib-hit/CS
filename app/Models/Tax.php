<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tax extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['tax_name', 'tax_amount'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    /**
     *  Invoices Realation Definition
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function invoices(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Invoice::class, 'invoice_tax', 'tax_id', 'invoice_id');
    }
}