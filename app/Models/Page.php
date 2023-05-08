<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Page extends Model
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

     /**
     * The "booting" method of the model
     * 
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        self::creating(function($page){
            $page->page = Page::where('album_id', $page->album_id)->max('page') + 1;
        });

        self::updating(function($page){
            if($page->isDirty('page')){
                $from = $page->getOriginal('page');
                $to   = $page->page;
                if($from < $to){
                    DB::update('update pages set page = page - 1 where album_id = ? and page > ? and page <= ?', [$page->album_id, $from, $to]);
                } else {
                    DB::update('update pages set page = page + 1 where album_id = ? and page >= ? and page < ?', [$page->album_id, $to, $from]);
                }
            }
        });

        self::deleted(function($page){
            DB::update('update pages set page = page - 1 where album_id = ? and page > ?', [$page->album_id, $page->page]);
        });
    }
}
