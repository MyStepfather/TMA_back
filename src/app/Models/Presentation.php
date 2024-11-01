<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\URL;

class Presentation extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'category_id',
        'title',
        'path'
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function getFullFilePathAttribute(): string
    {
        return URL::to('/') . "/storage/" . $this->path;
    }
}
