<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\ChartDashboard;
use App\Filament\Widgets\DashboardOverview;
use App\Filament\Widgets\StatsDashboard;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Actions\Action;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use Joaopaulolndev\FilamentEditProfile\Pages\EditProfilePage;

class AppPanelProvider extends PanelProvider
{

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('app')
            ->path('app')
            ->login()
            ->brandName('SIAK Metschoo')
            ->brandLogo(asset('img/LogoSIAKMS.png'))
            ->favicon(asset('img/LogoMetschoo.png'))
            ->brandLogoHeight('3rem')
            ->colors([
                'primary' => Color::Blue,
            ])
            ->plugins([
                FilamentShieldPlugin::make(),
                FilamentEditProfilePlugin::make()
                    ->slug('my-profile')
                    ->setTitle('My Profile')
                    ->setIcon('heroicon-o-user')
                    ->shouldShowAvatarForm(
                        value: true,
                        directory: 'photo_profile',
                        rules: 'mimes:jpeg,png|max:5024'
                    )
            ])
            ->userMenuItems([
                'profile' => Action::make('profile')
                    ->label(fn() => auth()->user()->name)
                    ->url(fn(): string => EditProfilePage::getUrl())
                    ->icon('heroicon-m-user-circle')
            ])
            ->maxContentWidth('full')
            ->navigationGroups([
                'Administrasi',
                'Master Data',
                'Data User',
            ])
            ->navigationItems([
                NavigationItem::make('MILES')
                    ->url('https://metschoo-ils.my.id/', shouldOpenInNewTab: true)
                    ->icon('heroicon-o-play'),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            // ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                // \App\Filament\Widgets\WelcomeWidget::class,
                \App\Filament\Widgets\StatsDashboard::class,
                \App\Filament\Widgets\ChartDashboard::class,
                \App\Filament\Widgets\StudentGenderChart::class,
                \App\Filament\Widgets\LatestActivityInformations::class,
                \App\Filament\Widgets\LatestInternalMemos::class,
            ])
            // ->databaseWidgetsColumns(5)
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
