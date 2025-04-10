<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'admin_accounts';

    protected $fillable = [
        'name',
        'username',
        'password',
        'profile_picture',
        'role'
    ];

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationship with messages
    public function messages()
    {
        return $this->hasMany(Message::class, 'admin_id');
    }

    // Handle profile picture display
    public function getProfilePictureAttribute()
    {
        $imagePath = $this->attributes['profile_picture'] ?? null;

        // If no image path is set, return default image
        if (!$imagePath) {
            return asset('assets/admin_profile_pictures/profile.jpg');
        }

        // If it's a Cloudinary URL, return it directly
        if (strpos($imagePath, 'cloudinary.com') !== false) {
            return $imagePath;
        }

        // Handle paths with storage/ prefix (old format)
        if (str_starts_with($imagePath, 'storage/')) {
            return asset($imagePath);
        }

        // Handle paths that already start with assets/
        if (str_starts_with($imagePath, 'assets/')) {
            return asset($imagePath);
        }

        // Handle paths with uploads/ prefix (legacy format)
        if (str_starts_with($imagePath, 'uploads/')) {
            return asset($imagePath);
        }

        // Handle paths that are just the filename or relative path without prefix
        // First check if it's in admin_profile_pictures directory format (old format)
        if (str_contains($imagePath, 'admin_profile_pictures/')) {
            return asset('storage/' . $imagePath);
        }

        // Legacy fallback - assume it's just a filename and prepend assets path
        return asset('assets/admin_profile_pictures/' . basename($imagePath));
    }
}