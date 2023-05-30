<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Letter extends Model
{
    use HasFactory;

    protected $table = 'letters';

    protected $fillable = [
        'title',
        'content',
        'date_to_send',
        'received',
        'read',
        'recipient_email',
        'user_id',
        'visibility_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function visibility(): BelongsTo
    {
        return $this->BelongsTo(Visibility::class);
    }

}
