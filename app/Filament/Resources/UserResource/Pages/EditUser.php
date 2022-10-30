<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Pages\Actions;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make()->after(function ($record){
                Notification::make()
                    ->title('Pengguna Dihapus')
                    ->icon('heroicon-o-users')
                    ->body("**Informasi Pengguna <b>{$record->name}</b> berhasil dihapus.**")
                    ->sendToDatabase(auth()->user());
            }),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($data['password'] === null && $data['password_confirmation'] === null){
            unset($data['password']);
            unset($data['password_confirmation']);
        }

        return $data;
    }

    protected function afterSave(): void
    {
        $user = $this->record;

        Notification::make()
            ->title('Pengguna Diubah')
            ->icon('heroicon-o-users')
            ->body("**Informasi Pengguna {$user->name} berhasil diubah.**")
            ->actions([
                Action::make('View')
                    ->url(UserResource::getUrl('edit', ['record' => $user])),
            ])
            ->sendToDatabase(auth()->user());
    }

}
