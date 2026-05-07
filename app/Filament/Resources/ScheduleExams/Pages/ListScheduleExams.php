<?php

namespace App\Filament\Resources\ScheduleExams\Pages;

use App\Filament\Resources\ScheduleExams\ScheduleExamResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListScheduleExams extends ListRecords
{
    protected static string $resource = ScheduleExamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
