<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Credentials extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $hidden = [
        'password',
    ];

    protected $fillable = [
        'password',
        'email',
        'google_id',
        'email_verified_at',
        'user_id',
        'role'
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
