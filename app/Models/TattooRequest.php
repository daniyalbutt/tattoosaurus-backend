<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TattooRequest extends Model
{
    protected $fillable = [
        'customer_id','artist_id','reference_images','idea','size','placement',
        'days','time_preference','budget','age_confirm','pronouns','timeframe','status',
        'tattoo_price', 'deposit_amount', 'payment_status',
        'status',
    ];
    protected $casts = ['reference_images' => 'array', 'days' => 'array', 'tattoo_price' => 'decimal:2', 'deposit_amount' => 'decimal:2',];

    public function customer() { return $this->belongsTo(User::class, 'customer_id'); }
    public function artist()   { return $this->belongsTo(User::class, 'artist_id'); }

    public function conversation()
    {
        return $this->hasOne(\App\Models\Conversation::class, 'tattoo_request_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getRemainingBalanceAttribute(): float
    {
        return (float) $this->tattoo_price - (float) $this->deposit_amount;
    }

    public function getStatusLabelAttribute(): array
    {
        // declined short-circuits everything
        if (($this->status ?? 'pending') === 'declined') {
            return ['Declined', 'danger'];
        }

        return match ($this->payment_status) {
            'fully_paid'        => ['Completed', 'success'],
            'booking_confirmed' => ['Deposit Paid', 'primary'],
            'payment_failed'    => ['Payment Failed', 'danger'],
            'refunded'          => ['Refunded', 'dark'],
            'deposit_pending'   => $this->status === 'approved'
                                    ? ['Awaiting Deposit', 'info']
                                    : ['Approved', 'info'],
            default             => $this->status === 'approved'
                                    ? ['Approved', 'info']
                                    : ['Pending', 'warning'],
        };
    }


    public function isPending()  { return $this->status === 'pending'; }
    public function isApproved() { return $this->status === 'approved'; }
    public function isDeclined() { return $this->status === 'declined'; }
}