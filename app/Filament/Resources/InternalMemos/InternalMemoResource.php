<?php

namespace App\Filament\Resources\InternalMemos;

use App\Filament\Resources\InternalMemos\Pages\CreateInternalMemo;
use App\Filament\Resources\InternalMemos\Pages\EditInternalMemo;
use App\Filament\Resources\InternalMemos\Pages\ListInternalMemos;
use App\Filament\Resources\InternalMemos\Schemas\InternalMemoForm;
use App\Filament\Resources\InternalMemos\Tables\InternalMemosTable;
use App\Models\InternalMemo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class InternalMemoResource extends Resource
{
    protected static ?string $model = InternalMemo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Internal Memo';

    public static function form(Schema $schema): Schema
    {
        return InternalMemoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InternalMemosTable::configure($table);
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
            'index' => ListInternalMemos::route('/'),
            'create' => CreateInternalMemo::route('/create'),
            'edit' => EditInternalMemo::route('/{record}/edit'),
        ];
    }
}
