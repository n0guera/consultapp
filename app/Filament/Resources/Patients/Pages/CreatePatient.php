<?php

namespace App\Filament\Resources\Patients\Pages;

use App\Filament\Resources\Patients\PatientResource;
use App\Models\Contact;
use App\Models\PersonalData;
use Filament\Resources\Pages\CreateRecord;

class CreatePatient extends CreateRecord
{
    protected static string $resource = PatientResource::class;

    protected static ?string $title = 'Nuevo Paciente';

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Crear el contacto
        $contact = Contact::create([
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
        ]);

        // Crear personal_data
        $personalData = PersonalData::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'dni' => $data['dni'],
            'birth_date' => $data['birth_date'] ?? null,
            'gender_id' => $data['gender_id'],
            'address' => $data['address'] ?? null,
            'contact_id' => $contact->id,
        ]);

        // Retornar solo los datos del paciente
        return [
            'personal_data_id' => $personalData->id,
            'active' => $data['active'] ?? true,
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Paciente creado exitosamente';
    }
}