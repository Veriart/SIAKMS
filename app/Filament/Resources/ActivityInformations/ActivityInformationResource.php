<?php

namespace App\Filament\Resources\ActivityInformations;

use App\Filament\Resources\ActivityInformations\Pages\CreateActivityInformation;
use App\Filament\Resources\ActivityInformations\Pages\EditActivityInformation;
use App\Filament\Resources\ActivityInformations\Pages\ListActivityInformations;
use App\Filament\Resources\ActivityInformations\Schemas\ActivityInformationForm;
use App\Filament\Resources\ActivityInformations\Tables\ActivityInformationsTable;
use App\Models\ActivityInformation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Filament\Concerns\HasResourcePermission;

class ActivityInformationResource extends Resource
{
    use HasResourcePermission;

    protected static ?string $permissionBase = 'ActivityInformation';

    protected static ?string $model = ActivityInformation::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Administrasi';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?string $navigationLabel = 'Activity Information';

    protected static ?string $modelLabel = 'Activity Information';

    protected static ?string $pluralModelLabel = 'Activity Information';

    public static function form(Schema $schema): Schema
    {
        return ActivityInformationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ActivityInformationsTable::configure($table);
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
            'index' => ListActivityInformations::route('/'),
            'create' => CreateActivityInformation::route('/create'),
            'edit' => EditActivityInformation::route('/{record}/edit'),
        ];
    }
}
