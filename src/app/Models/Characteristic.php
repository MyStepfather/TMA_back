<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Characteristic extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'device_id',
        'info'
    ];

    protected $casts = [
        'info' => 'array'
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }
}
