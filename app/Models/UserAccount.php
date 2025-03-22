<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    use HasFactory;

    protected $table = 'user_accounts';

    protected $fillable = [
        'id', 'firstName', 'lastName', 'username', 'age', 'gender', 
        'adrHouseNo', 'adrZone', 'adrStreet', 'birthday', 'password', 
        'user_profile_picture', 'user_valid_id', 'user_valid_id_back',
        'status', 'last_active', 'verified_at', 'rejected_at'
    ];

    protected $dates = [
        'verified_at',
        'rejected_at',
        'created_at',
        'last_active'
    ];
}
