<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Photo extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'favorite',
        'capacity',
        'uploaded_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'uploaded_at' => 'date',
    ];

    /**
     * Relation
     */
    public function user() { return $this->belongsTo(User::class); }
    public function pages() { return $this->hasMany(Page::class); }

    /**
     * Get file path
     */
    public function getPath(string $size=''): string
    {
        return sprintf('/%s/photos/%04d/%02d/%02d/%s%s.jpg',
            $this->user->email,
            $this->uploaded_at->year,
            $this->uploaded_at->month,
            $this->uploaded_at->day,
            $this->name, $size);
    }
}
