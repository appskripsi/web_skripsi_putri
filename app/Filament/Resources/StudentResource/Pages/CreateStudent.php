<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Student created')
            ->body('The student created successfully');
    }

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['password'] = !empty($data['password'])
            ? Hash::make($data['password'])
            : Hash::make($data['nim']);

        return $data;
    }
}
