<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Option extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'value',
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
    public function user() { return $this->belongsTo(User::class); }

    static public function get(string $name, $default = null)
    {
        $key = 'options-'.Auth::id().'-'.$name;
        return Cache::remember($key, 24 * 60 * 60, function() use($name, $default) {
            $option = Auth::user()->options()->where('name', $name)->first();
            if(is_null($option)){
                return $default;
            }
            return $option->value;
        });
    }

    static public function put(string $name, $value): void
    {
        DB::transaction(function() use($name, $value){
            $key = 'options-'.Auth::id().'-'.$name;
            Auth::user()->options()->updateOrCreate([
                'name' => $name,
            ],[
                'value' => $value,
            ]);
            Cache::put($key, $value, 24 * 60 * 60);
        });
    }

    public function scopeName($query, $name)
    {
        return $query->where('name', $name);
    }
}
