<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Pages\Actions;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function afterCreate(): void
    {

        $user = $this->record;


        Notification::make()
            ->title('Pengguna Baru')
            ->icon('heroicon-o-users')
            ->body("**Pengguna {$user->name} berhasil dibuat.**")
            ->actions([
                Action::make('View')
                    ->url(UserResource::getUrl('edit', ['record' => $user])),
            ])
            ->sendToDatabase(auth()->user());
    }
}
