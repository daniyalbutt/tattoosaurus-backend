<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtistReview extends Model
{
    protected $fillable = ['artist_id', 'customer_id', 'rating', 'comment'];

    public function artist()
    {
        return $this->belongsTo(User::class, 'artist_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}