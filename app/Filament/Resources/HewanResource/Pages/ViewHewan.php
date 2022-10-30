<?php

namespace App\Filament\Resources\HewanResource\Pages;

use App\Filament\Resources\HewanResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewHewan extends ViewRecord
{
    protected static string $resource = HewanResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
