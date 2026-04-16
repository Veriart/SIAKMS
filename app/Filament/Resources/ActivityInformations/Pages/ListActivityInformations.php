<?php

namespace App\Filament\Resources\ActivityInformations\Pages;

use App\Filament\Resources\ActivityInformations\ActivityInformationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListActivityInformations extends ListRecords
{
    protected static string $resource = ActivityInformationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
