<?php

namespace App\Filament\Resources\Teachers;

use BackedEnum;
use App\Models\Teacher;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Teachers\Pages\EditTeacher;
use App\Filament\Resources\Teachers\Pages\ListTeachers;
use App\Filament\Resources\Teachers\Pages\CreateTeacher;
use App\Filament\Resources\Teachers\Schemas\TeacherForm;
use App\Filament\Resources\Teachers\Tables\TeachersTable;

use App\Filament\Concerns\HasResourcePermission;

class TeacherResource extends Resource
{
    use HasResourcePermission;

    protected static ?string $permissionBase = 'Teacher';
    
    protected static string | \UnitEnum | null $navigationGroup = 'Data User';
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-user';

    protected static ?string $model = Teacher::class;

    // protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Teacher';

    public static function form(Schema $schema): Schema
    {
        return TeacherForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TeachersTable::configure($table);
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
            'index' => ListTeachers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditTeacher::route('/{record}/edit'),
        ];
    }
}
