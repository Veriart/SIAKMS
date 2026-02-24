<?php

namespace App\Filament\Resources\InternalMemos\Pages;

use App\Filament\Resources\InternalMemos\InternalMemoResource;
use App\Services\InternalMemoPdfService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateInternalMemo extends CreateRecord
{
    protected static string $resource = InternalMemoResource::class;

    protected function afterCreate(): void
    {
        $service = app(\App\Services\InternalMemoPdfService::class);

        $finalPath = $service->generateAndMerge($this->record);

        $this->record->update([
            'dispen_file' => $finalPath,
        ]);
    }
}
