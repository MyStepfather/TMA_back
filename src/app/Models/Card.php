<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'avatar',
        'position',
        'phone',
        'email',
        'whatsapp_phone',
        'company',
        'company_link',
        'qrcode',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
