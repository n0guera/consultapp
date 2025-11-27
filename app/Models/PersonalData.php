<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PersonalData extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'contact_id',
        'address',
        'birth_date',
        'gender_id',
        'dni',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    // Relaciones
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class);
    }

    public function patient(): HasOne
    {
        return $this->hasOne(Patient::class);
    }
}