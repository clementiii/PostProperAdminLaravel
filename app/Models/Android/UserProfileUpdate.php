<?php

namespace App\Models\Android;

use Illuminate\Database\Eloquent\Model;

class UserProfileUpdate extends Model
{
    protected $table = 'user_accounts';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'username', 'adrHouseNo', 'adrStreet', 'adrZone', 'password', 'user_profile_picture'
    ];
}
