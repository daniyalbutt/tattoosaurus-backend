<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'tattoo_request_id', 'customer_id', 'artist_id',
        'type', 'amount', 'platform_fee', 'total_charged',
        'stripe_payment_intent_id', 'stripe_checkout_session_id',
        'status', 'paid_at',
    ];

    protected $casts = [
        'amount'        => 'decimal:2',
        'platform_fee'  => 'decimal:2',
        'total_charged' => 'decimal:2',
        'paid_at'       => 'datetime',
    ];

    public function request()  { return $this->belongsTo(TattooRequest::class, 'tattoo_request_id'); }
    public function customer() { return $this->belongsTo(User::class, 'customer_id'); }
    public function artist()   { return $this->belongsTo(User::class, 'artist_id'); }
}