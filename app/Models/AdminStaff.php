<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminStaff extends Model
{
    use HasFactory;

    protected $table = 'admin_staff'; //database table

    protected $fillable = [
        'name', 'role', 'profile_picture',
    ];
}
