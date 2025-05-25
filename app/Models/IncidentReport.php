<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class IncidentReport extends Model
{
    use HasFactory;

    protected $table = 'incident_reports';

    protected $fillable = [
        'id', 'user_id', 'name', 'title', 'description', 'date_submitted', 'status', 'incident_picture', 'incident_video', 'resolved_at'
    ];

    protected $dates = [
        'date_submitted',
        'resolved_at',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'incident_picture' => 'array'
    ];
    
    /**
     * Get the formatted date in Manila timezone
     * 
     * @param Carbon|string $date
     * @return string
     */
    protected function formatManilaTime($date)
    {
        if (!$date) {
            return '';
        }
        
        if (is_string($date)) {
            $date = Carbon::parse($date);
        }
        
        // Convert to Manila timezone and format
        return $date->setTimezone('Asia/Manila')->format('M d, Y \a\t h:i A \(P\H\T\)');
    }

    /**
     * Get the properly formatted incident pictures
     *
     * @return array
     */
    public function getFormattedPicturesAttribute()
    {
        if (empty($this->incident_picture)) {
            return [];
        }

        // If it's already an array (thanks to $casts), process it
        if (is_array($this->incident_picture)) {
            return array_map(function($path) {
                return $this->formatImagePath($path);
            }, $this->incident_picture);
        }

        // If for some reason it's still a string, try to decode it
        $images = json_decode($this->incident_picture, true) ?: [];
        return array_map(function($path) {
            return $this->formatImagePath($path);
        }, $images);
    }

    /**
     * Format an image path by removing escaped slashes and ensuring it has the correct path
     *
     * @param string $path
     * @return string
     */
    protected function formatImagePath($path)
    {
        // Remove escaped slashes and any leading /storage/ as asset() will add the proper path
        $cleanPath = str_replace('\/','/', $path);
        
        // Remove any leading /storage/ as asset() will add the proper URL
        $cleanPath = Str::startsWith($cleanPath, '/storage/') 
            ? substr($cleanPath, 9)  // Remove '/storage/'
            : $cleanPath;
            
        return $cleanPath;
    }

    /**
     * Get the formatted video URL
     * 
     * @return string|null
     */
    public function getFormattedVideoAttribute()
    {
        if (empty($this->incident_video)) {
            return null;
        }
        
        // If it's a Cloudinary URL, it should already have https at the beginning
        if (Str::startsWith($this->incident_video, 'http')) {
            return $this->incident_video;
        }
        
        // If it's stored locally, add the storage path
        return asset('storage/' . $this->incident_video);
    }

    /**
     * Get the resolved timestamp as a formatted string in Manila time
     *
     * @return string|null
     */
    public function getFormattedResolvedAtAttribute()
    {
        return $this->formatManilaTime($this->resolved_at);
    }
    
    /**
     * Get the submitted date as a formatted string in Manila time
     *
     * @return string|null
     */
    public function getFormattedDateSubmittedAttribute()
    {
        return $this->formatManilaTime($this->date_submitted);
    }

    /**
     * Check if the report is resolved
     *
     * @return bool
     */
    public function isResolved()
    {
        return $this->status === 'resolved';
    }
}