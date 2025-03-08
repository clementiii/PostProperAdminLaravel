<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $table = 'barangay_announcements'; //table name
    protected $fillable = ['announcement_title', 'description_text', 'announcement_images', 'created_at', 'posted_at'];
    public $timestamps = false; //table already has `created_at` and `posted_at`
    
    
}
