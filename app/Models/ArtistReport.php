<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtistReport extends Model
{
    protected $fillable = ['artist_id', 'reporter_id', 'reason', 'details', 'status'];

    public function artist()
    {
        return $this->belongsTo(User::class, 'artist_id');
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }
}