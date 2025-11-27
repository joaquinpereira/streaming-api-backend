<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Series extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'synopsis',
        'release_year_start',
        'release_year_end',
        'tmdb_id',
        'poster_url',
        'rating',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'series_category');
    }

    public function seasons(): HasMany
    {
        return $this->hasMany(Season::class);
    }
}
