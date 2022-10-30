<?php

namespace App\Components\Actions;

use Filament\Tables\Actions\ViewAction as ActionsViewAction;

class ViewAction extends ActionsViewAction
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->icon('heroicon-o-eye');
    }

}
