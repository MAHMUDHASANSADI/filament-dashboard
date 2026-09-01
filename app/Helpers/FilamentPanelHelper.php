<?php

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

/**
 * Configure branding settings: favicon, and color scheme.
 */
function filament_branding(Panel $panel): Panel
{
    return $panel
        ->favicon(asset('images/ecom.png'))
        ->colors([
            'primary' => Color::Amber,
        ]);
}

/**
 * Configure auto-discovery for resources, pages, and widgets.
 */
function filament_discovery(Panel $panel): Panel
{
    return $panel
        ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
        ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
        ->pages([Dashboard::class])
        ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
        ->widgets([AccountWidget::class]);
}

/**
 * Configure the web and auth middleware stacks.
 */
function filament_panel_middleware(Panel $panel): Panel
{
    return $panel
        ->middleware([
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            AuthenticateSession::class,
            ShareErrorsFromSession::class,
            PreventRequestForgery::class,
            SubstituteBindings::class,
            DisableBladeIconComponents::class,
            DispatchServingFilamentEvent::class,
        ])
        ->authMiddleware([
            Authenticate::class,
        ]);
}
