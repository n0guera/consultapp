<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PersonalData extends Model
{
    use HasFactory;

    protected $table = 'personal_data';

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

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class, 'gender_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'personal_data_id');
    }

    public function patient(): HasOne
    {
        return $this->hasOne(Patient::class, 'personal_data_id');
    }


}
