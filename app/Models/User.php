<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admin_accounts'; // ✅ Ensure it's 'admin_accounts'
    protected $primaryKey = 'id';
    public $timestamps = false; // ✅ Disable timestamps if not in the table

    protected $fillable = [
        'name', 'username', 'password', 'profile_picture',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}