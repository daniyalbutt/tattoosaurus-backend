<?php

// app/Models/User.php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;   // <-- Spatie trait

    protected $fillable = [
        'name', 'username', 'email', 'phone', 'password',
        'status', 'otp_code', 'otp_expires_at',
    ];

    protected $hidden = ['password', 'remember_token', 'otp_code'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'otp_expires_at'    => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function artistProfile()
    {
        return $this->hasOne(ArtistProfile::class);
    }

    public function isPending(): bool { return $this->status === 'pending'; }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->artistProfile?->avatar) {
            return asset('storage/'.$this->artistProfile->avatar);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&size=80';
    }
}