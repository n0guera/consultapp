<?php

namespace App\Filament\Resources\Patients\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PatientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('personal_data_id')
                    ->relationship('personalData', 'id')
                    ->required(),
                Toggle::make('active')
                    ->required(),
            ]);
    }
}
