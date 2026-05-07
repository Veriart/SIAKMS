<?php

namespace App\Filament\Resources\ExamAttendances\Pages;

use App\Filament\Resources\ExamAttendances\ExamAttendanceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListExamAttendances extends ListRecords
{
    protected static string $resource = ExamAttendanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
