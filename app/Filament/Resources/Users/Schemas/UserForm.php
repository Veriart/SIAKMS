<?php

namespace App\Filament\Resources\Users\Schemas;

use components;
use App\Models\Role;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama')
                    ->required(),
                TextInput::make('email')
                    ->label('Email')
                    ->required()
                    ->email(),
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->dehydrated(fn($state) => filled($state))
                    ->helperText('Leave blank if you do not want to change the password'),
                Select::make('role_id')
                    ->label('Role')
                    ->required()
                    ->options(Role::pluck('name', 'id')->toArray()),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'Active' => 'Active',
                        'Inactive' => 'Inactive',
                    ])
                    ->default('Active'),

                /*
                 |----------------------
                 | FORM STUDENT
                 |----------------------
                 */
                Section::make('Student Data')
                    ->schema([
                        TextInput::make('student.nis')
                            ->label('NIS'),

                        TextInput::make('student.class')
                            ->label('Class'),
                    ])
                    ->visible(function (Get $get) {
                        $roleId = $get('role_id');
                        return Role::find($roleId)?->name === 'student';
                    }),

                /*
                 |----------------------
                 | FORM TEACHER
                 |----------------------
                 */
                Section::make('Teacher Data')
                    ->schema([
                        TextInput::make('teacher.nip')
                            ->label('NIP'),

                        TextInput::make('teacher.subject')
                            ->label('Subject'),
                    ])
                    ->visible(function (Get $get) {
                        $roleId = $get('role_id');
                        return Role::find($roleId)?->name === 'teacher';
                    }),
            ]);
    }
}
