<?php

namespace App\Filament\Resources\TeacherAdministrations\Pages;

use App\Filament\Resources\TeacherAdministrations\TeacherAdministrationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTeacherAdministrations extends ListRecords
{
    protected static string $resource = TeacherAdministrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
