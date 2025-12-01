<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;
use Illuminate\Support\HtmlString;


class ConsultorioPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('consultorio')
            ->path('consultorio')
            ->login()
            ->brandName('ConsultApp')
            ->brandLogo(fn() => new HtmlString('
            <div style="display: flex; align-items: center; gap: 15px;">
                <img 
                    src="' . asset('images/logo.png') . '" 
                    alt="Logo ConsultApp" 
                    style="height: 40px; width: auto;" 
                />
                
                <span style="font-size: 30px; font-weight: bold; color: inherit; line-height: 1;">
                    ConsultApp
                </span>
            </div>
        '))

            // Ajusta la altura automática para que no corte tu nuevo diseño
            ->brandLogoHeight('5rem')
            ->spa()

            ->colors([
                'primary' => Color::Green,
            ])
            ->plugin(
                FilamentFullCalendarPlugin::make()
            )
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            /* ->pages([
                Dashboard::class,
            ]) */
            ->pages([
                \App\Filament\Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                //AccountWidget::class,
                //FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
