<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminProfile extends Authenticatable

{
    use HasFactory;

    protected $table = 'admin_accounts';

    protected $fillable = [
        'id', 'name', 'username', 'password', 'profile_picture'
    ];
}
