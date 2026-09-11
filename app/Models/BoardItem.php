<?php
// app/Models/BoardItem.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardItem extends Model
{
    protected $fillable = ['customer_id', 'artist_id', 'image_path'];

    public function customer() { return $this->belongsTo(User::class, 'customer_id'); }
    public function artist()   { return $this->belongsTo(User::class, 'artist_id'); }
}