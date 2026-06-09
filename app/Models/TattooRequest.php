<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TattooRequest extends Model
{
    protected $fillable = [
        'customer_id','artist_id','reference_images','idea','size','placement',
        'days','time_preference','budget','age_confirm','pronouns','timeframe','status',
    ];
    protected $casts = ['reference_images' => 'array', 'days' => 'array'];

    public function customer() { return $this->belongsTo(User::class, 'customer_id'); }
    public function artist()   { return $this->belongsTo(User::class, 'artist_id'); }

    public function conversation()
    {
        return $this->hasOne(\App\Models\Conversation::class, 'tattoo_request_id');
    }
}