<?php

namespace App\Filament\Resources\Appointments;

use App\Filament\Resources\Appointments\Pages;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;

use Illuminate\Support\Facades\Auth;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationLabel = 'Agenda / Turnos';
    protected static ?string $modelLabel = 'Turno';
    protected static ?string $pluralModelLabel = 'Turnos';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([

                // === SECCIÓN IZQUIERDA (Principal) ===
                Section::make('Información del Turno')
                    ->columnSpan(2)
                    ->components([

                        Select::make('patient_id')
                            ->label('Paciente')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->getSearchResultsUsing(
                                fn(string $search): array => \App\Models\Patient::query()
                                    ->whereHas('personalData', function ($query) use ($search) {
                                        $query->where('first_name', 'like', "%{$search}%")
                                            ->orWhere('last_name', 'like', "%{$search}%")
                                            ->orWhere('dni', 'like', "%{$search}%");
                                    })
                                    ->limit(50)
                                    ->get()
                                    ->mapWithKeys(fn($patient) => [$patient->id => $patient->full_name])
                                    ->toArray()
                            )
                            ->getOptionLabelUsing(fn($value) => \App\Models\Patient::find($value)?->full_name)
                            ->exists(table: 'patients', column: 'id')
                            ->columnSpanFull(),

                        Grid::make(2)->schema([
                            Select::make('reason')
                                ->label('Motivo')
                                ->options([
                                    'Consulta Inicial' => 'Consulta Inicial',
                                    'Control' => 'Control / Seguimiento',
                                    'Urgencia' => 'Urgencia',
                                ])
                                ->required(),

                            Select::make('status_id')
                                ->label('Estado')
                                ->options(\App\Models\Status::all()->pluck('status_name', 'id'))
                                ->default(fn() => \App\Models\Status::first()?->id)
                                ->required()
                                ->selectablePlaceholder(false)
                                ->native(false),
                        ]),

                        Grid::make(2)->schema([
                            DateTimePicker::make('start_date')
                                ->label('Inicio')
                                ->seconds(false)
                                ->minutesStep(15)
                                ->default(now()->addHour()->startOfHour())
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(function ($set, $state) {
                                    if ($state) {
                                        $set('end_date', Carbon::parse($state)->addHour());
                                    }
                                }),

                            DateTimePicker::make('end_date')
                                ->label('Fin')
                                ->seconds(false)
                                ->minutesStep(15)
                                ->required()
                                ->afterOrEqual('start_date'),
                        ]),
                    ]),

                Section::make('Profesional y Ajustes')
                    ->columnSpan(1)
                    ->components([
                        Select::make('user_id')
                            ->label('Nutricionista')
                            ->relationship('user', 'name')
                            ->default(fn() => Auth::id())
                            ->required(),

                        Toggle::make('send_reminder')
                            ->label('Enviar recordatorio')
                            ->default(true)
                            ->onColor('success'),

                        Textarea::make('cancellation_reason')
                            ->label('Motivo Cancelación')
                            ->placeholder('Solo si se cancela...')
                            ->rows(3),

                        TextInput::make('created_at')
                            ->label('Creado')
                            ->disabled()
                            ->dehydrated(false)
                            ->formatStateUsing(fn(?Appointment $record) => $record?->created_at?->format('d/m/Y H:i') ?? '-'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('patient_full_name') // Nombre arbitrario
                    ->label('Paciente')
                    // Usamos getStateUsing para forzar el uso del Accesor 'full_name'
                    ->getStateUsing(fn(Appointment $record) => $record->patient?->full_name ?? 'Sin datos')
                    // Búsqueda personalizada: Buscamos dentro de la relación anidada
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereHas('patient', function (Builder $q) use ($search) {
                            $q->whereHas('personalData', function (Builder $q2) use ($search) {
                                $q2->where('first_name', 'like', "%{$search}%")
                                    ->orWhere('last_name', 'like', "%{$search}%");
                            });
                        });
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('start_date')
                    ->label('Fecha')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status.status_name')
                    ->label('Estado')
                    ->badge()
                    //->placeholder('Sin asignar')
                    ->color(fn($state): string => match ($state) {
                        'Agendado' => 'warning',   // Amarillo
                        'Cancelado' => 'danger',   // Rojo
                        'Ausente' => 'gray',      // Gris
                        default => 'gray',
                    }),
            ])
            ->defaultSort('start_date', 'desc')
            ->filters([])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
