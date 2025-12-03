<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Filament\Resources\Appointments\AppointmentResource;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;

class TodayAppointmentsWidget extends BaseWidget
{
    protected static bool $isLazy = true;
    // Orden 1 para que salga arriba de todo
    protected static ?int $sort = 1;

    // Ocupar todo el ancho disponible
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Appointment::query()
                    ->whereDate('start_date', today()) // Filtro: Solo hoy
                    ->orderBy('start_date', 'asc')
            )
            ->heading('Turnos para Hoy, ' . now()->translatedFormat('l d \d\e F'))
            ->columns([
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Hora')
                    ->dateTime('H:i')
                    ->weight('bold')
                    ->color('primary'),

                Tables\Columns\TextColumn::make('patient.full_name')
                    ->label('Paciente')
                    ->searchable()
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('reason')
                    ->label('Motivo')
                    ->color('gray'),

                Tables\Columns\TextColumn::make('status.status_name')
                    ->label('Estado')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Confirmado' => 'info',
                        'Atendido'   => 'success',
                        'Cancelado'  => 'danger',
                        'Ausente'    => 'warning',
                        default      => 'gray',
                    }),
            ])
            ->actions([
                // Botón discreto para gestionar el turno
                \Filament\Actions\Action::make('gestionar')
                    ->label('Ver')
                    ->icon(LucideIcon::SquarePen)
                    ->color('gray')
                    ->url(fn(Appointment $record) => AppointmentResource::getUrl('edit', ['record' => $record])),
            ])
            ->paginated(false); // Lista compacta sin páginas
    }
}
