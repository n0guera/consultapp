<?php

namespace App\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use App\Models\Appointment;
use App\Filament\Resources\Appointments\AppointmentResource;
use Saade\FilamentFullCalendar\Actions; // Acciones del plugin
use Illuminate\Database\Eloquent\Model;

class AppointmentCalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = Appointment::class;

    /**
     * 1. Cargar Eventos de la Base de Datos
     */
    public function fetchEvents(array $fetchInfo): array
    {
        return Appointment::query()
            ->with(['patient', 'status']) // Carga optimizada
            ->where('start_date', '>=', $fetchInfo['start'])
            ->where('end_date', '<=', $fetchInfo['end'])
            ->get()
            ->map(
                fn(Appointment $event) => [
                    'id'    => $event->id,
                    // Usamos el Accesor full_name. Si es null, mostramos texto de respaldo
                    'title' => $event->patient?->full_name ?? 'Sin Paciente',
                    'start' => $event->start_date,
                    'end'   => $event->end_date,
                    // Lógica de colores según el nombre del estado en tu DB
                    'color' => match ($event->status?->status_name) {
                        'Agendado'   => '#eab308', // Amarillo
                        'Confirmado' => '#22c55e', // Verde
                        'Cancelado'  => '#ef4444', // Rojo
                        'Atendido'   => '#6b7280', // Gris
                        default      => '#3b82f6', // Azul (Default)
                    },
                ]
            )
            ->toArray();
    }

    protected function getHeaderWidgets(): array
    {
        return [
            AppointmentCalendarWidget::class,
        ];
    }
    /**
     * 2. Definir el Formulario del Modal (Overlay)
     * ¡Reutilizamos el del Recurso para no escribirlo dos veces!
     */
    public function getFormSchema(): array
    {
        return AppointmentResource::getFormComponents();
    }

    /**
     * 3. Configurar Acciones (Botones)
     */
    protected function headerActions(): array
    {
        return [ // Ancho grande para tu diseño de 3 columnas
        ];
    }

    protected function modalActions(): array
    {
        return [
            \Filament\Actions\EditAction::make()
                ->modalHeading('Editar Turno')
                ->modalWidth('5xl'),

            \Filament\Actions\DeleteAction::make()
                ->modalHeading('Eliminar Turno'),
        ];
    }

    /**
     * 4. Configuración Visual del Calendario
     */
    public function config(): array
    {
        return [
            'firstDay' => 1, // La semana empieza el Lunes
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'dayGridMonth,timeGridWeek,timeGridDay',
            ],
            'initialView' => 'dayGridMonth', // Vista semanal por defecto (como tu imagen)
            'slotMinTime' => '07:00:00',     // Hora inicio visual
            'slotMaxTime' => '21:00:00',     // Hora fin visual
            'allDaySlot' => false,           // Ocultar fila "Todo el día"
            'nowIndicator' => true,          // Línea roja de la hora actual
        ];
    }
}
