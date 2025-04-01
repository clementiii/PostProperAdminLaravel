<?php

namespace App\Models\Android;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;

    protected $table = 'user_accounts';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'firstName',
        'lastName',
        'username',
        'password',
        'adrHouseNo',
        'adrZone',
        'adrStreet',
        'age',
        'gender',
        'birthday',
        'user_profile_picture',
        'last_active'
    ];

    public function getFullAddressAttribute()
    {
        return "{$this->adrHouseNo}, {$this->adrStreet}, Zone {$this->adrZone}";
    }
}
