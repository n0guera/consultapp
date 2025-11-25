<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'role_id',
        'credential_id',
        'personal_data_id',
        'active',
    ];
    
    protected $hidden = [
        'remember_token',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function credential(): BelongsTo
    {
        return $this->belongsTo(Credential::class, 'credential_id');
    }

    public function personalData(): BelongsTo
    {
        return $this->belongsTo(PersonalData::class, 'personal_data_id');
    }

    public function getAuthPassword(): string
    {
        return $this->credential->password;
    }
    
    public function getEmailAttribute(): ?string
    {
        return $this->personalData->contact->email ?? null;
    }

    public function getNameAttribute(): string
    {
        return $this->personalData->first_name . ' ' . $this->personalData->last_name;
    }

    // Se eliminó el método 'casts' que definía 'password' => 'hashed', 
    // ya que la contraseña no está en esta tabla.
}