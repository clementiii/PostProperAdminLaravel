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
        'adrHouseNo', 'adrZone', 'adrStreet', 'birthday', 'password', 'user_profile_picture',
    ];
}
