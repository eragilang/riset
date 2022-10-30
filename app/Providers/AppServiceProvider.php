<?php

namespace App\Providers;

use App\Filament\Resources\UserResource;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Navigation\UserMenuItem;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Filament::serving(function () {
            Filament::registerNavigationGroups([
                NavigationGroup::make()
                    ->label('Settings')
                    ->collapsed(),
            ]);

            Filament::registerUserMenuItems([
                UserMenuItem::make()
                    ->label('Profile')
                    ->url(UserResource::getUrl('profile'))
                    ->icon('heroicon-s-user'),
                // ...
            ]);

        });
    }
}
