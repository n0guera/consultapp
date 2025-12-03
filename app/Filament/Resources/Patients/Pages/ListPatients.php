<?php

namespace App\Filament\Resources\Patients\Pages;

use App\Filament\Resources\Patients\PatientResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;

class ListPatients extends ListRecords
{
    protected static string $resource = PatientResource::class;

    protected static ?string $title = 'Mis Pacientes';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Nuevo Paciente')
                ->icon(LucideIcon::Plus)
                ->color('success')
        ];
    }
}
