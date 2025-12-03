<?php

namespace App\Filament\Resources\Patients\Pages;

use App\Filament\Resources\Patients\PatientResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;

class EditPatient extends EditRecord
{
    protected static string $resource = PatientResource::class;

    protected static ?string $title = 'Editar Paciente';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Eliminar Paciente')
                ->icon(LucideIcon::UserMinus)
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $patient = $this->record;

        return [
            'first_name' => $patient->personalData->first_name,
            'last_name' => $patient->personalData->last_name,
            'dni' => $patient->personalData->dni,
            'birth_date' => $patient->personalData->birth_date,
            'gender_id' => $patient->personalData->gender_id,
            'address' => $patient->personalData->address,
            'email' => $patient->personalData->contact->email ?? null,
            'phone' => $patient->personalData->contact->phone ?? null,
            'active' => $patient->active,
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $patient = $this->record;

        // Actualizar contacto
        $patient->personalData->contact->update([
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
        ]);

        // Actualizar personal_data
        $patient->personalData->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'dni' => $data['dni'],
            'birth_date' => $data['birth_date'] ?? null,
            'gender_id' => $data['gender_id'],
            'address' => $data['address'] ?? null,
        ]);

        // Retornar solo datos del paciente
        return [
            'active' => $data['active'] ?? true,
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Paciente actualizado exitosamente';
    }
}
