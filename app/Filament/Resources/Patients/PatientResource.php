<?php

namespace App\Filament\Resources\Patients;

use App\Filament\Resources\Patients\Pages;
use App\Models\Patient;
use App\Models\Gender;
use BackedEnum;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Components\Section;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Pacientes';

    protected static ?string $modelLabel = 'Paciente';

    protected static ?string $pluralModelLabel = 'Pacientes';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información Personal')
                    ->components([
                        Forms\Components\TextInput::make('first_name')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(100),

                        Forms\Components\TextInput::make('last_name')
                            ->label('Apellido')
                            ->required()
                            ->maxLength(100),

                        Forms\Components\TextInput::make('dni')
                            ->label('DNI')
                            ->required()
                            ->unique(table: 'personal_data', 
                            column: 'dni',
                            modifyRuleUsing: function (\Illuminate\Validation\Rules\Unique $rule, $record) {
                                // Si hay un registro (estamos editando) y tiene ID de datos personales...
                                if ($record && $record->personal_data_id) {
                                    // ...le decimos a la regla Unique que ignore ESE ID específico
                                    return $rule->ignore($record->personal_data_id);
                                }
                                return $rule;
                            }
                            )
                            ->maxLength(20),

                        Forms\Components\DatePicker::make('birth_date')
                            ->label('Fecha de Nacimiento')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->maxDate(now()),

                        Forms\Components\Select::make('gender_id')
                            ->label('Género')
                            ->options(Gender::pluck('name', 'id'))
                            ->required()
                            ->preload(),

                        Forms\Components\Textarea::make('address')
                            ->label('Dirección')
                            ->maxLength(255)
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Información de Contacto')
                    ->components([
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(100),

                        Forms\Components\TextInput::make('phone')
                            ->label('Teléfono')
                            ->tel()
                            ->maxLength(20),
                    ])
                    ->columns(2),

                Section::make('Estado')
                    ->components([
                        Forms\Components\Toggle::make('active')
                            ->label('Activo')
                            ->default(true),
                    ])
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Nombre Completo')
                    ->searchable(['personalData.first_name', 'personalData.last_name'])
                    ->sortable()
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Teléfono')
                    ->default('—'),

                // Fecha de nacimiento (sin default, formateamos manualmente)
                Tables\Columns\TextColumn::make('personalData.birth_date')
                    ->label('Fecha de Nacimiento')
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        return blank($state)
                            ? '—'
                            : ($state instanceof \DateTimeInterface
                                ? $state->format('d/m/Y')
                                : \Carbon\Carbon::parse($state)->format('d/m/Y'));
                    }),

                // Último turno (obtenemos el estado y lo formateamos)
                Tables\Columns\TextColumn::make('last_appointment')
                    ->label('Último Turno')
                    ->sortable()
                    ->getStateUsing(
                        fn(Patient $record) =>
                        $record->appointments()
                            ->latest('start_date')
                            ->value('start_date')
                    )
                    ->formatStateUsing(function ($state) {
                        return blank($state)
                            ? '—'
                            : ($state instanceof \DateTimeInterface
                                ? $state->format('d/m/Y')
                                : \Carbon\Carbon::parse($state)->format('d/m/Y'));
                    }),

                Tables\Columns\TextColumn::make('active')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn(bool $state): string => $state ? 'Activo' : 'Inactivo')
                    ->color(fn(bool $state): string => $state ? 'success' : 'gray'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('active')
                    ->label('Estado')
                    ->options([
                        '1' => 'Activos',
                        '0' => 'Inactivos',
                    ])
                    ->default('1'),
            ])
            ->recordActions([
                \Filament\Actions\Action::make('view')
                    ->label('Ver Ficha')
                    ->icon('heroicon-o-eye')
                    ->url(fn(Patient $record): string => PatientResource::getUrl('edit', ['record' => $record]))
                    ->button()
                    ->color('gray'),
            ])
            ->groupedBulkActions([
                \Filament\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc')
            ->searchPlaceholder('Buscar por nombre, apellido, email o Teléfono...')
            ->emptyStateHeading('No hay pacientes registrados')
            ->emptyStateDescription('Crea un nuevo paciente para comenzar.')
            ->emptyStateIcon('heroicon-o-user-group');
    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('active', true)->count();
    }
}
