<?php

namespace App\Filament\Resources\TeacherAdministrations;

use App\Filament\Resources\TeacherAdministrations\Pages\CreateTeacherAdministration;
use App\Filament\Resources\TeacherAdministrations\Pages\EditTeacherAdministration;
use App\Filament\Resources\TeacherAdministrations\Pages\ListTeacherAdministrations;
use App\Filament\Resources\TeacherAdministrations\Schemas\TeacherAdministrationForm;
use App\Filament\Resources\TeacherAdministrations\Tables\TeacherAdministrationsTable;
use App\Models\TeacherAdministration;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class TeacherAdministrationResource extends Resource
{
    protected static ?string $model = TeacherAdministration::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Administrasi';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Teacher Administration';

    public static function form(Schema $schema): Schema
    {
        return TeacherAdministrationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TeacherAdministrationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $user = Auth::user();

        if ($user->hasRole('Teacher')) {
            return $query->where('user_id', $user->id);
        }

        return $query;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTeacherAdministrations::route('/'),
            'create' => CreateTeacherAdministration::route('/create'),
            'edit' => EditTeacherAdministration::route('/{record}/edit'),
        ];
    }
}
