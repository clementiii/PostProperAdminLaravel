<?php

namespace App\Models\Android;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'user_accounts';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'firstName', 'lastName', 'username', 'age', 'gender', 
        'adrHouseNo', 'adrZone', 'adrStreet', 'birthday', 'password',
        'user_profile_picture', 'status'
    ];
}