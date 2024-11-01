<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\URL;

class Requisite extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'date',
        'entities',
        'path'
    ];

    protected $casts = [
        'entities' => 'object',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function getFullFilePathAttribute(): string
    {
        return URL::to('/') . "/storage/" . $this->path;
    }
}
