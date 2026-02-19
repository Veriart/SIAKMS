<?php

namespace App\Filament\Resources\Students\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

class StudentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('student_number')
                    ->label('No. Induk')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('classroom.name')
                    ->label('Classroom')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('expertise.name')
                    ->label('Expertise')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('academicYear.in')
                    ->label('Academic Year')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('gender')
                    ->label('Gender')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('religion')
                    ->label('Religion')
                    ->sortable()
                    ->searchable(),
                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'Student',
                        'danger' => 'Alumni',
                    ])
                    ->default('Student')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
