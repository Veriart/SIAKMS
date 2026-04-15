<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class WelcomeWidget extends Widget
{
    use HasWidgetShield;

    protected string $view = 'filament.widgets.welcome-widget';
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';

    public function getGreeting(): string
    {
        $hour = date('H');
        
        if ($hour < 12) {
            return 'Selamat Pagi';
        } elseif ($hour < 15) {
            return 'Selamat Siang';
        } elseif ($hour < 18) {
            return 'Selamat Sore';
        } else {
            return 'Selamat Malam';
        }
    }
}
