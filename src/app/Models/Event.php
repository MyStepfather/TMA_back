<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'date',
        'type',
        'isActive'
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(EventType::class);
    }
}
