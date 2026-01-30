<?php

namespace App\Filament\Resources\Teachers\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class TeacherForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->disabled()
                    ->dehydrated()
                    ->afterStateHydrated(fn ($component, $record) => $component->state($record?->user?->name)),
                TextInput::make('nip')->label('NIP')->required(),
                Select::make('gender')
                    ->label('Gender')
                    ->options([
                        'Pria' => 'Pria',
                        'Wanita' => 'Wanita',
                    ])
                    ->required(),
                Select::make('religion')
                    ->label('Religion')
                    ->options([
                        'Islam' => 'Islam',
                        'Kristen' => 'Kristen',
                        'Katolik' => 'Katolik',
                        'Hindu' => 'Hindu',
                        'Budha' => 'Budha',
                    ])
                    ->required(),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'Active' => 'Active',
                        'Inactive' => 'Inactive',
                    ])
                    ->default('Active')
                    ->required(),
            ]);
    }
}
