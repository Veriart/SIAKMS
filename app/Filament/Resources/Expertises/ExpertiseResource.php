<?php

namespace App\Filament\Resources\Expertises;

use App\Filament\Resources\Expertises\Pages\CreateExpertise;
use App\Filament\Resources\Expertises\Pages\EditExpertise;
use App\Filament\Resources\Expertises\Pages\ListExpertises;
use App\Filament\Resources\Expertises\Schemas\ExpertiseForm;
use App\Filament\Resources\Expertises\Tables\ExpertisesTable;
use App\Models\Expertise;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

use App\Filament\Concerns\HasResourcePermission;

class ExpertiseResource extends Resource
{
    use HasResourcePermission;

    protected static ?string $permissionBase = 'Expertise';
    
    protected static string | \UnitEnum | null $navigationGroup = 'Master Data';
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $model = Expertise::class;

    // protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Expertise';

    public static function form(Schema $schema): Schema
    {
        return ExpertiseForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExpertisesTable::configure($table);
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
            'index' => ListExpertises::route('/'),
            'create' => CreateExpertise::route('/create'),
            'edit' => EditExpertise::route('/{record}/edit'),
        ];
    }
}
