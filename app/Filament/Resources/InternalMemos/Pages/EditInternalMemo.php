<?php

namespace App\Filament\Resources\InternalMemos\Pages;

use App\Filament\Resources\InternalMemos\InternalMemoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInternalMemo extends EditRecord
{
    protected static string $resource = InternalMemoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
