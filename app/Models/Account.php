<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'identifier',
        'provider_name',
        'is_primary',
        'balance',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
