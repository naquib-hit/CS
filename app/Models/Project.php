<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{ Model, SoftDeletes };
use Illuminate\Database\Eloquent\Relations\{ BelongsTo, HasMany };

class Project extends Model
{
    use HasFactory, SoftDeletes;

    
    protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'created_by'];
    protected $guarded = ['id'];

    /**
     * Definitins for customer relationship
     * 
     * @return BelongsTo
     */
    public function customers(): BelongsTo 
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    /**
     * Definitins for Invoice relationship
     * 
     * @return HasMany
     */
    public function invoices(): HasMany 
    {
        return $this->hasMany(Invoice::class, 'project_id', 'id');
    }
}
