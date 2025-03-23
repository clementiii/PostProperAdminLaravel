<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    
    protected $fillable = [
        'sender_id',
        'admin_id',
        'message',
        'is_admin'
    ];

    protected $casts = [
        'timestamp' => 'datetime',
        'is_admin' => 'boolean'
    ];

    public $timestamps = false;

    public function sender()
    {
        return $this->belongsTo(UserAccount::class, 'sender_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
} 