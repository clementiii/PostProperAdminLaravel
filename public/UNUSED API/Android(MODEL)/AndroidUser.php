<?php

namespace App\Models\Android;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class AndroidUser extends Model
{
    use HasFactory;

    protected $table = 'user_accounts';

    protected $fillable = [
        'firstName', 'lastName', 'username', 'password', 'age',
        'birthday', 'adrHouseNo', 'adrZone', 'adrStreet', 'gender', 'user_valid_id', 'user_valid_id_back'
    ];
    protected $hidden = ['password'];
}