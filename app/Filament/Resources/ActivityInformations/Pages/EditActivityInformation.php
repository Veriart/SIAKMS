<?php

namespace App\Filament\Resources\ActivityInformations\Pages;

use App\Filament\Resources\ActivityInformations\ActivityInformationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditActivityInformation extends EditRecord
{
    protected static string $resource = ActivityInformationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
