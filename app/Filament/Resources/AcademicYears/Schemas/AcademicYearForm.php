<?php

namespace App\Filament\Resources\AcademicYears\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AcademicYearForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('in')
                    ->label('Tahun Masuk')
                    ->numeric()
                    ->required()
                    ->maxLength(4)
                    ->live()
                    ->afterStateUpdated(fn ($state, $set) => $set('out', $state ? (string)((int)$state + 3) : '')),
                TextInput::make('out')
                    ->label('Tahun Keluar')
                    ->numeric()
                    ->required()
                    ->maxLength(4),
            ]);
    }
}
