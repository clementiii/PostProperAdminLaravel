<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'admin_accounts';

    protected $fillable = ['name', 'role', 'profile_picture'];

    // Handle multiple profile picture locations
    public function getProfilePictureAttribute()
    {
        $imagePath = $this->attributes['profile_picture'] ?? null;

        // If no image path is set, return default image
        if (!$imagePath) {
            return asset('assets/admin_profile_pictures/profile.jpg');
        }

        // Handle paths with storage/ prefix (new format from our controller)
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
        // First check if it's in admin_profile_pictures directory format (our new format)
        if (str_contains($imagePath, 'admin_profile_pictures/')) {
            return asset('storage/' . $imagePath);
        }

        // Legacy fallback - assume it's just a filename and prepend assets path
        return asset('assets/admin_profile_pictures/' . basename($imagePath));
    }
}