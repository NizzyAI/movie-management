<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Movie extends Model {
    use HasFactory;

    protected $fillable = ['title', 'category_id', 'director', 'release_date', 'synopsis', 'poster'];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function getPosterUrlAttribute() {
        return $this->poster ? asset('storage/' . $this->poster) : null;
    }
}
