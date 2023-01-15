<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceSummary extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Invoice Realationship Definition
     * 
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invoice(): BelongsTo 
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }
    
}
