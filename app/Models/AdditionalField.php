<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdditionalField extends Model
{
    use HasFactory;

    /**
     * Mutable data assigment
     * 
     * @var string[]
     */
    protected $fillable = ['invoice_id', 'field_name', 'field_value', 'unit', 'operation'];
    /**
     * Immutable data assignment
     * 
     * @var string[]
     */
    protected $guard = ['id'];
    /**
     * hidden data assignment
     * 
     * @var string[]
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Invoice Realtionship Definition
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invoices(): BelongsTo 
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }
}
