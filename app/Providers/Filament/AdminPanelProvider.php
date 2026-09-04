<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $panel = $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->databaseNotifications()
            ->spa();

        $panel = filament_branding($panel);
        $panel = filament_discovery($panel);
        $panel = filament_panel_middleware($panel);
        $panel = filament_antivirus($panel);


        return $panel;
    }
}
