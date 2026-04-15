<?php

namespace App\Filament\Resources\AcademicAdministrations;

use App\Filament\Resources\AcademicAdministrations\Pages\CreateAcademicAdministration;
use App\Filament\Resources\AcademicAdministrations\Pages\EditAcademicAdministration;
use App\Filament\Resources\AcademicAdministrations\Pages\ListAcademicAdministrations;
use App\Filament\Resources\AcademicAdministrations\Schemas\AcademicAdministrationForm;
use App\Filament\Resources\AcademicAdministrations\Tables\AcademicAdministrationsTable;
use App\Models\AcademicAdministration;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AcademicAdministrationResource extends Resource
{
    protected static ?string $model = AcademicAdministration::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Administrasi';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Academic Administration';

    public static function form(Schema $schema): Schema
    {
        return AcademicAdministrationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AcademicAdministrationsTable::configure($table);
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
            'index' => ListAcademicAdministrations::route('/'),
            'create' => CreateAcademicAdministration::route('/create'),
            'edit' => EditAcademicAdministration::route('/{record}/edit'),
        ];
    }
}
