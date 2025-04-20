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

    // No timestamps as we're using the timestamp column
    public $timestamps = false;

    /**
     * Get the user who sent this message
     */
    public function sender()
    {
        return $this->belongsTo(UserAccount::class, 'sender_id');
    }

    /**
     * Get the admin associated with this message
     */
    public function admin()
    {
        return $this->belongsTo(AdminAccount::class, 'admin_id');
    }
}