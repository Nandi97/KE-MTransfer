<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VerificationCode extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id',
        'identifier',
        'code',
        'expires_at',
        'verified'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'verified' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
