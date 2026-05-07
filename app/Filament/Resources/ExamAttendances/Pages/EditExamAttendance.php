<?php

namespace App\Filament\Resources\ExamAttendances\Pages;

use App\Filament\Resources\ExamAttendances\ExamAttendanceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditExamAttendance extends EditRecord
{
    protected static string $resource = ExamAttendanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
