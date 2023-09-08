<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $table = 'movies';

    protected $guarded = [];

    public function genres(){
        return $this->belongsToMany(Genre::class, 'movie_genres', 'movie_id', 'genre_id');
    }

    public function users(){
        return $this->belongsToMany(User::class, 'movie_favorites', 'movie_id', 'user_id');
 
    }
}
