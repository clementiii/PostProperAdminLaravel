<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'admin_accounts';
    protected $fillable = ['name', 'email', 'password', 'profile_picture'];

    public function getProfilePictureAttribute()
    {
        return $this->profile_picture ? asset('storage/' . $this->profile_picture) : asset('assets/default-profile.jpg');
    }
}
