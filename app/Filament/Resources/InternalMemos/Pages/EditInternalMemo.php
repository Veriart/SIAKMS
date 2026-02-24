<?php

namespace App\Filament\Resources\InternalMemos\Pages;

use App\Filament\Resources\InternalMemos\InternalMemoResource;
use App\Services\InternalMemoPdfService;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditInternalMemo extends EditRecord
{
    protected static string $resource = InternalMemoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $record = $this->record;

        $service = app(InternalMemoPdfService::class);

        // Hapus file lama jika ada
        if ($record->dispen_file) {
            Storage::disk('public')->delete($record->dispen_file);
        }

        // Generate ulang
        $finalPath = $service->generateAndMerge($record);
        // Update path baru
        $record->update([
            'dispen_file' => $finalPath,
        ]);
    }
}
