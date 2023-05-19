<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPhoto extends Model
{
    use HasFactory;

    protected $table = 'category_photo';
    protected $primaryKey = ['category_id', 'photo_id'];
    public $incrementing = false;
    public $timestamps = false;
}
