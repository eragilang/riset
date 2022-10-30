<?php

namespace App\Components\Actions;

use Filament\Tables\Actions\DeleteAction as ActionsDeleteAction;

class DeleteAction extends ActionsDeleteAction
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->icon('heroicon-o-trash');
    }

}
