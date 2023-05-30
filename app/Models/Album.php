<?php

namespace App\Models;

use App\Enums\Album\Status;
use App\Events\AlbumDeleted;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Album extends Model
{
    use HasFactory, SoftDeletes, Sortable, Prunable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'status',
        'title',
        'author',
        'publisher',
        'capacity',
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
        'status' => Status::class,
    ];

    /**
     * The attribute that sortable.
     * 
     * @var array<int, string>
     */
    protected $sortable = [
        'title',
        'updated_at',
    ];

    /**
     * Relation
     */
    public function user() { return $this->belongsTo(User::class); }
    public function pages()  { return $this->hasMany(Page::class); }

    /**
     * Get file path
     */
    public function getDirectory(): string
    {
        return sprintf('users/%s/albums/%08d', $this->user->email, $this->id);
    }

     public function getEpubPath(): string
    {
        return $this->getDirectory().'.epub';
    }

    public function getCoverPath(): string
    {
        return $this->getDirectory().'/cover.jpg';
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

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'deleted' => AlbumDeleted::class,
    ];

    /**
     * The "booting" method of the model
     * 
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        self::creating(function($album){
            $album->uuid = Str::uuid();
        });

        self::deleting(function($album){
            if($album->isForceDeleting()){
                foreach($album->pages()->cursor() as $page){
                    $page->delete();
                }
            } else {
                $album->status = Status::TRASHED;
                $album->save();
            }
        });

        self::restoring(function($album){
            if(Storage::disk('s3')->exists($album->getEpubPath())){
                $album->status = Status::PUBLISHED;
            } else {
                $album->status = Status::NONE;
            }
        });
    }
}
