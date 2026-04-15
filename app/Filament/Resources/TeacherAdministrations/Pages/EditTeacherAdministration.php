<?php

namespace App\Filament\Resources\TeacherAdministrations\Pages;

use App\Filament\Resources\TeacherAdministrations\TeacherAdministrationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTeacherAdministration extends EditRecord
{
    protected static string $resource = TeacherAdministrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
