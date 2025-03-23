<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminAccount extends Authenticatable
{
    protected $table = 'admin_accounts';

    protected $fillable = [
        'name',
        'username',
        'password',
        'profile_picture'
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
} 