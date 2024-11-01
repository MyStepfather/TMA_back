<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EventType extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'type',
        'title'
    ];

    public function events(): HasOne
    {
        return $this->hasOne(Event::class);
    }
}
