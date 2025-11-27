<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ContentFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_type',
        'content_id',
        'video_url',
        'mime_type',
    ];

    public function content(): MorphTo
    {
        return $this->morphTo();
    }
}
