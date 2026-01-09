<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = [];

    protected $appends = ['attachment_url'];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // relasi ke penerima pesan (recipient_id)
    public function Recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function getAttachmentUrlAttribute()
    {
        if ($this->attachment_path) {
            return asset('storage/' . $this->attachment_path);
        }
        return null;
    }
}
