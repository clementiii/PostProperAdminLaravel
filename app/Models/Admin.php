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
        $imagePath = $this->attributes['profile_picture'];

        if (!$imagePath) {
            return asset('assets/admin_profile_pictures/profile.jpg'); // Default image if null
        }

        // Check if the path starts with 'uploads/' or 'ssets/'
        if (str_starts_with($imagePath, 'uploads/')) {
            return asset($imagePath);
        }

        return asset('assets/admin_profile_pictures/' . basename($imagePath));
    }
}