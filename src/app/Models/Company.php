<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function presentations(): HasMany
    {
        return $this->hasMany(Presentation::class);
    }

    public function requisites(): HasMany
    {
        return $this->hasMany(Requisite::class);
    }
}
