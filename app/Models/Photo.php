<?php

namespace App\Models;

use App\Events\PhotoDeleted;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Prunable;

class Photo extends Model
{
    use HasFactory, SoftDeletes, Prunable;

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
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'deleted' => PhotoDeleted::class,
    ];

    /**
     * Relation
     */
    public function user() { return $this->belongsTo(User::class); }
    public function pages() { return $this->hasMany(Page::class); }
    public function categories() { return $this->belongsToMany(Category::class, 'category_photo'); }

    /**
     * Get file path
     */
    public function getDirectory(): string
    {
        return sprintf('users/%s/photos/%04d/%02d/%02d',
            $this->user->email,
            $this->uploaded_at->year,
            $this->uploaded_at->month,
            $this->uploaded_at->day,
        );
    }

     public function getPath(string $size=''): string
    {
        return sprintf('%s/%08d%s.jpg',
            $this->getDirectory(),
            $this->id, $size
        );
    }

    /**
     * Get the prunable model query.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function prunable()
    {
        return static::query()
                    ->whereNotNull('deleted_at')
                    ->where('deleted_at', '<', now()->subDay((int)config('app.expire_day')));       
    }
}
