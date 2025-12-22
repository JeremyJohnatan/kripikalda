<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class EmailOtp extends Model
{
    use HasFactory;

    protected $table = 'email_otps';

    protected $fillable = [
        'email',
        'otp',
        'expired_at',
        'verified',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
        'verified'   => 'boolean',
    ];

    /**
     * Cek apakah OTP masih valid (belum expired)
     */
    public function isExpired(): bool
    {
        return $this->expired_at->isPast();
    }
}
