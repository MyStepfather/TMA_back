<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'birthday',
    ];

    public function card(): HasMany
    {
        return $this->hasMany(Card::class);
    }

    public function opozduns(): HasMany
    {
        return $this->hasMany(Opozdun::class);
    }

}
