<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Contact extends Model
{
    use HasFactory;
    
    protected $table = 'contacts';

    protected $fillable = [
        'phone',
        'email',
    ];

    // La FK 'contact_id' se encuentra en la tabla 'personal_data'
    public function personalData(): HasOne
    {
        return $this->hasOne(PersonalData::class, 'contact_id');
    }
}
