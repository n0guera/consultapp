<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClinicalNote extends Model
{
    use HasFactory;
    
    protected $table = 'clinical_notes';
    
    protected $fillable = [
        'appointment_id',
        'observations',
        'instructions',
        'diagnosis',
    ];

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }
}