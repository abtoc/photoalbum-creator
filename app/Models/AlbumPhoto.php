<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AlbumPhoto extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'album_id',
        'photo_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];

    /**
     * Relation
     */
     public function album() { return $this->belongsTo(Album::class); }
     public function photo() { return $this->belongsTo(Photo::class); }
     public function album_photos()  { return $this->hasMany(AlbumPhoto::class); }

     /**
     * The "booting" method of the model
     * 
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        self::creating(function($album_photo){
            $album_photo->page = AlbumPhoto::where('album_id', $album_photo->album_id)->max('page') + 1;
        });

        self::updating(function($album_photo){
            if($album_photo->isDirty('page')){
                $from = $album_photo->getOriginal('page');
                $to   = $album_photo->page;
                if($from < $to){
                    DB::update('update album_photos set page = page - 1 where album_id = ? and page > ? and page <= ?', [$album_photo->album_id, $from, $to]);
                } else {
                    DB::update('update album_photos set page = page + 1 where album_id = ? and page >= ? and page < ?', [$album_photo->album_id, $to, $from]);
                }
            }
        });

        self::deleted(function($album_photo){
            DB::update('update album_photos set page = page - 1 where album_id = ? and page > ?', [$album_photo->album_id, $album_photo->page]);
        });
    }
}
