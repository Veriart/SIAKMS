<?php

namespace App\Filament\Resources\Classrooms\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class ClassroomForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Kelas')
                    ->required()
                    ->maxLength(255),
            ]);
    }
}
