<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use MoonShine\Fields\Relationships\HasMany;

class Opozdun extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'opozdun_type_id',
        'answer',
        'type'
    ];

    protected $casts = [
        'answer' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(OpozdunType::class);
    }
}
