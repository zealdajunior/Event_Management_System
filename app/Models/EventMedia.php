<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EventMedia extends Model
{
    use HasFactory;

    protected $table = 'event_media';

    protected $fillable = [
        'event_id',
        'event_request_id',
        'file_name',
        'file_path',
        'file_type',
        'mime_type',
        'file_size',
        'order',
        'caption',
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'file_size' => 'integer',
        'order' => 'integer',
    ];

    /**
     * Get the event that owns the media.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the event request that owns the media.
     */
    public function eventRequest()
    {
        return $this->belongsTo(EventRequest::class);
    }

    /**
     * Get the full URL of the media file.
     */
    public function getUrlAttribute()
    {
        return Storage::url($this->file_path);
    }

    /**
     * Check if the media is an image.
     */
    public function isImage()
    {
        return $this->file_type === 'image';
    }

    /**
     * Check if the media is a video.
     */
    public function isVideo()
    {
        return $this->file_type === 'video';
    }

    /**
     * Get human-readable file size.
     */
    public function getFormattedSizeAttribute()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Delete the media file from storage.
     */
    public function deleteFile()
    {
        if (Storage::exists($this->file_path)) {
            Storage::delete($this->file_path);
        }
    }

    /**
     * Boot method to handle model events.
     */
    protected static function boot()
    {
        parent::boot();

        // Delete file when model is deleted
        static::deleting(function ($media) {
            $media->deleteFile();
        });
    }
}
