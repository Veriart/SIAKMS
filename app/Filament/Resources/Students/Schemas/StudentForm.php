<?php

namespace App\Filament\Resources\Students\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class StudentForm
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
                TextInput::make('student_number')->label('No. Induk')->required(),
                Select::make('classroom_id')->label('Class Room')->relationship('classroom', 'name')->required(),
                Select::make('expertise_id')->label('Expertise')->relationship('expertise', 'name')->required(),
                Select::make('academic_year_id')->label('Academic Year')->relationship('academicYear', 'in')->required(),
                Select::make('gender')
                    ->label('Gender')
                    ->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan',
                    ])
                    ->required(),
                Select::make('religion')
                    ->label('Religion')
                    ->options([
                        'Islam' => 'Islam',
                        'Kristen' => 'Kristen',
                        'Katolik' => 'Katolik',
                        'Hindu' => 'Hindu',
                        'Buddha' => 'Buddha',
                    ])
                    ->required(),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'Student' => 'Student',
                        'Alumni' => 'Alumni',
                    ])
                    ->default('Student')
                    ->required(),
            ]);
    }
}
