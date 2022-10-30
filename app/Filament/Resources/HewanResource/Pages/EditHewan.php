<?php

namespace App\Filament\Resources\HewanResource\Pages;

use App\Filament\Resources\HewanResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EditHewan extends EditRecord
{
    protected static string $resource = HewanResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        if ($record->objek != $data['objek']){
            Storage::disk('public')->delete($record->objek);
        }
        $record->update($data);

        return $record;
    }
}
