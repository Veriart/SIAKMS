<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class DashboardOverview extends Widget
{
    protected string $view = 'filament.widgets.dashboard-overview';

    protected int|string|array $columnSpan = 'full';
}
