<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'api_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'api_token',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * GetCapacity
     *
     * @return int
     */
    public function getCapacity(): int
    {
        return 100 * 1024 * 1024;
    }    

    public function getUsedCapacity(): int
    {
        return (int)$this->photos()->withTrashed()->selectRaw('sum(capacity) as capacity')->first()->capacity
             + (int)$this->albums()->withTrashed()->selectRaw('sum(capacity) as capacity')->first()->capacity;
    }    

    /**
     * Relation
     */
    public function photos()  { return $this->hasMany(Photo::class); }
    public function albums()  { return $this->hasMany(Album::class); }
}
