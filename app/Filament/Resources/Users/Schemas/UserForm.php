<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\Role;
use App\Models\Subject;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('User Data')
                ->schema([
                    Grid::make([
                        'default' => 1,
                        'md' => 2,
                    ])
                        ->schema([
                            TextInput::make('name')
                                ->label('Name')
                                ->required(),

                            TextInput::make('email')
                                ->label('Email')
                                ->email()
                                ->required(),

                            TextInput::make('password')
                                ->label('Password')
                                ->password()
                                ->required()
                                ->dehydrated(fn($state) => filled($state)),

                            Select::make('role_id')
                                ->label('Role')
                                ->options(Role::pluck('name', 'id')->toArray())
                                ->live()
                                ->required(),

                            Select::make('status')
                                ->label('Status')
                                ->options([
                                    'Active' => 'Active',
                                    'Inactive' => 'Inactive',
                                ])
                                ->default('Active')
                                ->required(),
                        ]),
                ]),

            Grid::make([
                'default' => 1,
                'md' => 2,
            ])
                ->schema([
                    Section::make('Student Data')
                        ->relationship('student')
                        ->schema([
                            Grid::make([
                                'default' => 1,
                                'md' => 2,
                            ])
                                ->schema([
                                    TextInput::make('identification_number')->label('No. Induk')->required(),
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
                                ])
                        ])
                        ->columnSpanFull()
                        ->visible(
                            fn(Get $get) =>
                            Role::find($get('role_id'))?->name === 'Student'
                        ),

                    Section::make('Teacher Data')
                        ->relationship('teacher')
                        ->schema([
                            Grid::make([
                                'default' => 1,
                                'md' => 2,
                            ])
                                ->schema([
                                    TextInput::make('nip')->label('NIP')->required(),
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
                                            'Active' => 'Active',
                                            'Inactive' => 'Inactive',
                                        ])
                                        ->default('Active')
                                        ->required(),
                                    // Select::make('subject_id')
                                    //     ->label('Subject')
                                    //     ->options(Subject::pluck('name', 'id')->toArray()),
                                ])
                        ])
                        ->columnSpanFull()
                        ->visible(
                            fn(Get $get) =>
                            Role::find($get('role_id'))?->name === 'Teacher'
                        ),
                ]),
        ]);
    }
}
