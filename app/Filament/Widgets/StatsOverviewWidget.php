<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use App\Models\Patient;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;

class StatsOverviewWidget extends BaseWidget
{
    // Esto ordena el widget en la pantalla (ponemos 2 para que salga después de la tabla de hoy)
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        return [
            Stat::make('Pacientes Activos', Patient::where('active', true)->count())
                ->description('Total registrados')
                ->icon(LucideIcon::Users)
                ->color('success'),

            Stat::make('Turnos este Mes', Appointment::whereMonth('start_date', now()->month)->count())
                ->description('Agendados en ' . now()->monthName)
                ->icon(LucideIcon::CalendarDays)
                ->chart([7, 2, 10, 3, 15, 4, 17]) // Gráfico decorativo
                ->color('info'),

            Stat::make('Tasa de Ausencia', '15%') // Dato simulado por ahora
                ->description('Promedio mensual')
                ->icon(LucideIcon::TriangleAlert)
                ->color('danger'),
        ];
    }
}
