<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    use HasFactory;
    
    protected $table = 'patients';
    
    protected $fillable = [
        'personal_data_id', 
        'active'
    ];


    public function personalData(): BelongsTo
    {
        return $this->belongsTo(PersonalData::class, 'personal_data_id');
    }

    
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    
    public function measurements(): HasMany
    {
        return $this->hasMany(Measurement::class, 'patient_id');
    }
}