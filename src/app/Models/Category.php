<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'title'
    ];

    public function categoryType(): BelongsTo
    {
        return $this->belongsTo(CategoryType::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function devices(): BelongsToMany
    {
        return $this->belongsToMany(Device::class);
    }

    public function presentations(): BelongsToMany
    {
        return $this->belongsToMany(Presentation::class);
    }

}
