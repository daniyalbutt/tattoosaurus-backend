<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'conversation_id', 'sender_id', 'body',
        'attachment_path', 'attachment_name', 'attachment_type',
    ];
    protected $casts = ['read_at' => 'datetime'];
    public function sender() { return $this->belongsTo(User::class, 'sender_id'); }
}