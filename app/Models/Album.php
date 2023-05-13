<?php

namespace App\Models;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Album extends Model
{
    use HasFactory, SoftDeletes, Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'author',
        'publisher',
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
    public function getPath(): string
    {
        return sprintf('%s/albums/%08d/%08d.epub', 
            Auth::user()->email,
            $this->id,
            $this->id,
        );
    }
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
    }
}
