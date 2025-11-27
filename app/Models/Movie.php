<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'synopsis',
        'release_year',
        'duration_min',
        'tmdb_id',
        'poster_url',
        'rating',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'movie_category');
    }

    public function contentFile(): MorphOne
    {
        return $this->morphOne(ContentFile::class, 'content');
    }
}
