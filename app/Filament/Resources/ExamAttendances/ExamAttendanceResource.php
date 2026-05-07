<?php

namespace App\Filament\Resources\ExamAttendances;

use App\Filament\Resources\ExamAttendances\Pages\CreateExamAttendance;
use App\Filament\Resources\ExamAttendances\Pages\EditExamAttendance;
use App\Filament\Resources\ExamAttendances\Pages\ListExamAttendances;
use App\Filament\Resources\ExamAttendances\Schemas\ExamAttendanceForm;
use App\Filament\Resources\ExamAttendances\Tables\ExamAttendancesTable;
use App\Models\ExamAttendance;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use App\Filament\Concerns\HasResourcePermission;

class ExamAttendanceResource extends Resource
{
    use HasResourcePermission;

    protected static ?string $permissionBase = 'ExamAttendance';

    protected static ?string $model = ExamAttendance::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Ujian';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationLabel = 'Kehadiran Ujian';

    protected static ?string $modelLabel = 'Kehadiran Ujian';

    protected static ?string $pluralModelLabel = 'Kehadiran Ujian';

    public static function form(Schema $schema): Schema
    {
        return ExamAttendanceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExamAttendancesTable::configure($table);
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
            'index' => ListExamAttendances::route('/'),
            'create' => CreateExamAttendance::route('/create'),
            'edit' => EditExamAttendance::route('/{record}/edit'),
        ];
    }
}
