<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\URL;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'category_id',
        'title',
        'path',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getFullPathAttribute(): string
    {
        return URL::to('/') . "/storage/" . $this->path;
    }
}
