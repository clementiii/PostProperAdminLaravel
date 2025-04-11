<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $table = 'barangay_announcements'; //table name
    protected $fillable = ['announcement_title', 'description_text', 'announcement_images', 'created_at', 'posted_at'];
    public $timestamps = false; //table already has `created_at` and `posted_at`
    
    // Add an accessor to handle the announcement images
    public function getAnnouncementImagesAttribute($value)
    {
        if (!$value) {
            return [];
        }
        
        // Decode the JSON string to array
        $images = json_decode($value, true);
        
        // If decoding fails or value isn't an array, return empty array
        if (!is_array($images)) {
            return [];
        }
        
        return $images;
    }

    // Add a mutator to ensure proper JSON encoding
    public function setAnnouncementImagesAttribute($value)
    {
        $this->attributes['announcement_images'] = is_array($value) ? json_encode($value) : $value;
    }
}
