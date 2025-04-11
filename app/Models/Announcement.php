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
    
    /**
     * Get the announcement images.
     *
     * @param  string  $value
     * @return array
     */
    public function getAnnouncementImagesAttribute($value)
    {
        // If the value is already an array, return it
        if (is_array($value)) {
            return $value;
        }
        
        // If the value is null or empty, return an empty array
        if (empty($value)) {
            return [];
        }
        
        // Try to decode the JSON string
        $decoded = json_decode($value, true);
        
        // If decoding fails or doesn't result in an array, return empty array
        if (!is_array($decoded)) {
            return [];
        }
        
        return $decoded;
    }
    
    /**
     * Set the announcement images.
     *
     * @param  mixed  $value
     * @return void
     */
    public function setAnnouncementImagesAttribute($value)
    {
        // If already a JSON string, don't encode again
        if (is_string($value) && (strpos($value, '[') === 0 || strpos($value, '{') === 0)) {
            $this->attributes['announcement_images'] = $value;
        } else {
            $this->attributes['announcement_images'] = is_array($value) ? json_encode($value) : $value;
        }
    }
}
