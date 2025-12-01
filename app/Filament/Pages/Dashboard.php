<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use App\Filament\Resources\Appointments\AppointmentResource;
use Illuminate\Support\Facades\Auth;

class Dashboard extends BaseDashboard
{
    // Cambiamos el título
    public function getTitle(): string
    {
        return "¡Hola, " . Auth::user()->name . "!";
    }

    // Agregamos los botones del Header
    protected function getHeaderActions(): array
    {
        return [
            Action::make('agendar')
                ->label('Agendar Nuevo Turno')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->url(AppointmentResource::getUrl('create')), // Te lleva a crear turno

            Action::make('agenda_completa')
                ->label('Ver Agenda Completa')
                ->icon('heroicon-o-calendar')
                ->color('gray')
                ->url(AppointmentResource::getUrl('index')), // Te lleva al listado
        ];
    }
}