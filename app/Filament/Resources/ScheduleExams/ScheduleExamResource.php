<?php

namespace App\Filament\Resources\ScheduleExams;

use App\Filament\Resources\ScheduleExams\Pages\CreateScheduleExam;
use App\Filament\Resources\ScheduleExams\Pages\EditScheduleExam;
use App\Filament\Resources\ScheduleExams\Pages\ListScheduleExams;
use App\Filament\Resources\ScheduleExams\Schemas\ScheduleExamForm;
use App\Filament\Resources\ScheduleExams\Tables\ScheduleExamsTable;
use App\Models\ScheduleExam;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Filament\Concerns\HasResourcePermission;

class ScheduleExamResource extends Resource
{
    use HasResourcePermission;

    protected static ?string $permissionBase = 'ScheduleExam';

    protected static ?string $model = ScheduleExam::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Ujian';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationLabel = 'Jadwal Ujian';

    protected static ?string $modelLabel = 'Jadwal Ujian';

    protected static ?string $pluralModelLabel = 'Jadwal Ujian';

    public static function form(Schema $schema): Schema
    {
        return ScheduleExamForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ScheduleExamsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListScheduleExams::route('/'),
            'create' => CreateScheduleExam::route('/create'),
            'edit' => EditScheduleExam::route('/{record}/edit'),
        ];
    }
}
