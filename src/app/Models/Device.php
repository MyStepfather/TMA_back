<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\URL;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'thumb',
        'gallery'
    ];

    protected $casts = [
        'gallery' => 'array',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function characteristic(): HasOne
    {
        return $this->hasOne(Characteristic::class);
    }

    public function getFullThumbPathAttribute()
    {
        return URL::to('/') . "/storage/" . $this->thumb;
    }

    public function getFullGalleryPathAttribute()
    {
        return array_map(function ($item) {
            return URL::to('/') . "/storage/" . $item;
        }, $this->gallery);
    }
}
