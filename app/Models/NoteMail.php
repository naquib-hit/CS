<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class NoteMail extends Model
{
    use HasFactory, SoftDeletes;
    
    public function project(): BelongsTo 
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}
