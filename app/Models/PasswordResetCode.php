<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PasswordResetCode extends Model
{
    protected $fillable = [
        'email',
        'code',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function scopeValid($query)
    {
        return $query->where('expires_at', '>', Carbon::now());
    }

    public function scopeByEmail($query, $email)
    {
        return $query->where('email', $email);
    }

    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
    }

    public static function generateCode()
    {
        return str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    public static function createForEmail($email)
    {
        // Delete any existing codes for this email
        static::where('email', $email)->delete();

        return static::create([
            'email' => $email,
            'code' => static::generateCode(),
            'expires_at' => Carbon::now()->addMinutes(15), // Code expires in 15 minutes
        ]);
    }
}
