<?php

namespace App\Filament\Resources\ScheduleExams\Pages;

use App\Filament\Resources\ScheduleExams\ScheduleExamResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditScheduleExam extends EditRecord
{
    protected static string $resource = ScheduleExamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
