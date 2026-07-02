<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'thumbnail',
        'video_type',
        'youtube_url',
        'video_file',
        'status',
        'sort_order',
    ];

    public function category()
    {
        return $this->belongsTo(VideoCategory::class, 'category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Returns the playable URL regardless of source (youtube or uploaded file).
     */
    public function getPlayUrlAttribute(): ?string
    {
        if ($this->video_type === 'youtube' && $this->youtube_url) {
            return $this->youtube_url;
        }

        if ($this->video_type === 'upload' && $this->video_file) {
            return asset('storage/' . $this->video_file);
        }

        return null;
    }

    /**
     * Returns a YouTube embed URL if this is a YouTube video.
     */
    public function getEmbedUrlAttribute(): ?string
    {
        if ($this->video_type !== 'youtube' || !$this->youtube_url) {
            return null;
        }

        $url = $this->youtube_url;
        $videoId = null;

        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/', $url, $matches)) {
            $videoId = $matches[1];
        }

        return $videoId ? "https://www.youtube.com/embed/{$videoId}" : null;
    }
}
