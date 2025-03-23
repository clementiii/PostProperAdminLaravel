<?php

namespace App\Models\Android;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;

    protected $table = 'user_accounts'; // Your table name

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'firstName',
        'lastName',
        'username',
        'adrHouseNo',
        'adrZone',
        'adrStreet',
        'age',
        'gender',
        'birthday',
        'user_profile_picture'
    ];

    // Full address attribute
    public function getFullAddressAttribute()
    {
        return "{$this->adrHouseNo}, {$this->adrStreet}, Zone {$this->adrZone}";
    }
}
