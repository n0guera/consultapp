<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gender extends Model
{
    use HasFactory;
    
    protected $table = 'genders';
    
    protected $fillable = ['name'];

    public function personalData(): HasMany
    {
        return $this->hasMany(PersonalData::class, 'gender_id');
    }
}