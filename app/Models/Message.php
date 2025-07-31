<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'application_id',
        'message',
         'sender_type',
    ];

    public function application()
    {
        return $this->belongsTo(JobApplication::class, 'application_id');
    }


    // message notification
public function isUnread()
{
    return is_null($this->read_at);
}



// In App\Models\Message.php
public function getCreatedAtManilaAttribute()
{
    return $this->created_at->timezone('Asia/Manila')->format('F d, Y h:i A');
}

}
