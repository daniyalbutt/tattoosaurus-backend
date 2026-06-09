<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = ['customer_id','artist_id','tattoo_request_id'];
    public function messages() { return $this->hasMany(Message::class)->latest(); }
    public function customer() { return $this->belongsTo(User::class, 'customer_id'); }
    public function artist()   { return $this->belongsTo(User::class, 'artist_id'); }
    public function request()  { return $this->belongsTo(TattooRequest::class, 'tattoo_request_id'); }
}
