<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Appointment;
use Illuminate\Support\Carbon;

class AttendanceChartWidget extends ChartWidget
{
    protected ?string $heading = 'Asistencia Semanal';
    
    // Orden 3 para que aparezca después de la tabla y al lado de las métricas
    protected static ?int $sort = 3; 

    // Ocupa 1 columna (la mitad de la pantalla abajo)
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
    
        return [
            'datasets' => [
                [
                    'label' => 'Pacientes atendidos',
                    'data' => [4, 6, 8, 5, 7, 3, 6], 
                    'backgroundColor' => '#0d9486', 
                    'borderRadius' => 4, // 
                ],
            ],
            'labels' => ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}