<?php

namespace App\Filament\Resources\HewanResource\Pages;

use App\Filament\Resources\HewanResource;
use App\Models\Hewan;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHewans extends ListRecords
{
    protected static string $resource = HewanResource::class;


    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function isTableSearchable(): bool
    {
        return true;
    }


}
