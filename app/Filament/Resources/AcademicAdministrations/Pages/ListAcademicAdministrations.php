<?php

namespace App\Filament\Resources\AcademicAdministrations\Pages;

use App\Filament\Resources\AcademicAdministrations\AcademicAdministrationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAcademicAdministrations extends ListRecords
{
    protected static string $resource = AcademicAdministrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
