<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use App\Models\Patient;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    // Esto ordena el widget en la pantalla (ponemos 2 para que salga después de la tabla de hoy)
    protected static ?int $sort = 2; 

    protected function getStats(): array
    {
        return [
            Stat::make('Pacientes Activos', Patient::where('active', true)->count())
                ->description('Total registrados')
                ->icon('heroicon-o-users')
                ->color('success'),

            Stat::make('Turnos este Mes', Appointment::whereMonth('start_date', now()->month)->count())
                ->description('Agendados en ' . now()->monthName)
                ->icon('heroicon-o-calendar')
                ->chart([7, 2, 10, 3, 15, 4, 17]) // Gráfico decorativo
                ->color('info'),

            Stat::make('Tasa de Ausencia', '15%') // Dato simulado por ahora
                ->description('Promedio mensual')
                ->icon('heroicon-o-exclamation-triangle')
                ->color('danger'),
        ];
    }
}