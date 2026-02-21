<?php

namespace App\Filament\Resources\InternalMemos\Pages;

use App\Filament\Resources\InternalMemos\InternalMemoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInternalMemos extends ListRecords
{
    protected static string $resource = InternalMemoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
