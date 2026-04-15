<?php

namespace App\Filament\Resources\AcademicAdministrations\Pages;

use App\Filament\Resources\AcademicAdministrations\AcademicAdministrationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAcademicAdministration extends EditRecord
{
    protected static string $resource = AcademicAdministrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
