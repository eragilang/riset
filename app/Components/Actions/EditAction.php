<?php

namespace App\Components\Actions;

use Filament\Tables\Actions\EditAction as ActionsEditAction;

class EditAction extends ActionsEditAction
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->icon('heroicon-o-pencil');
    }

}
