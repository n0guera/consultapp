<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Credential extends Model
{
    use HasFactory;
    
    protected $table = 'credentials';

    protected $fillable = [
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function user(): HasOne
    {
        // La FK 'credential_id' se encuentra en la tabla 'users'.
        return $this->hasOne(User::class, 'credential_id');
    }
}
