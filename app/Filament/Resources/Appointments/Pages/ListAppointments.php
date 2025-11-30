<?php

namespace App\Filament\Resources\Appointments\Pages; // Asegúrate que este namespace coincida con tu carpeta real

use App\Filament\Resources\Appointments\AppointmentResource; // Asegúrate que la ruta al Resource sea correcta
use App\Filament\Resources\Appointments\Widgets\AppointmentCalendarWidget; // Importamos tu Widget
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Table;
use Filament\Actions;

class ListAppointments extends ListRecords
{
    protected static string $resource = AppointmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Nuevo Turno')
                ->icon('heroicon-o-plus')
                ->color('success')

        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            AppointmentCalendarWidget::class,
        ];
    }

    public function getVisibleTableColumns(): array
    {
        return [];
    }


    public function table(Table $table): Table
    {
        return parent::table($table)
            // Quitamos la paginación
            ->paginated(false)
            // Quitamos el texto "No records found"
            ->emptyStateHeading(null)
            ->emptyStateDescription(null)
            ->emptyStateIcon(null)
            // Quitamos botones extra
            ->emptyStateActions([])
            ->headerActions([]);
    }
}
