<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{ Model, SoftDeletes };
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['customer_name', 'customer_address', 'customer_email', 'customer_phone'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * Project relationship definition
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects(): HasMany 
    {
        return $this->hasMany(Project::class, 'customer_id', 'id');
    }

    /**
     * Transaction relationship definition
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions() : HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
