<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Appointment;
use Illuminate\Support\Carbon;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class AttendanceChartWidget extends ChartWidget
{
    protected static bool $isLazy = true;
    protected ?string $heading = 'Asistencia Semanal';
    
    // Orden 3 para que aparezca después de la tabla y al lado de las métricas
    protected static ?int $sort = 3; 

    // Ocupa 1 columna (la mitad de la pantalla abajo)
    protected int | string | array $columnSpan = 'full';

    protected ?string $maxHeight = '250px';

    protected function getData(): array
    {

        $data = Trend::query(
                Appointment::query()
                    // Filtramos: Solo contamos los que realmente vinieron ("Atendido")
                    // Si prefieres contar todos los agendados, borra esta línea.
                    ->whereHas('status', fn ($q) => $q->where('status_name', 'Atendido'))
            )
            ->between(
                start: now()->startOfWeek(), // Desde el Lunes pasado
                end: now()->startOfWeek()->addDays(5),     // Hasta este Domingo
            )
            ->perDay() // Agrupar por día
            ->count();
    
        return [
            'datasets' => [
                [
                    'label' => 'Pacientes atendidos',
                    // Mapeamos los datos para extraer solo el número (aggregate)
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#0d9486', // Teal
                    'borderRadius' => 4, 
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