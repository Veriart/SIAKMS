<?php

namespace App\Filament\Resources\Users\Tables;

use App\Filament\Concerns\ExportHelper;
use components;
use App\Models\Role;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;

class UsersTable
{
    private static function exportColumns(): array
    {
        return [
            'name' => 'Nama',
            'email' => 'Email',
            'role.name' => 'Role',
            'status' => 'Status',
        ];
    }

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                SelectColumn::make('role_id')
                    ->label('Role')
                    ->options(Role::pluck('name', 'id')->toArray())
                    ->searchable()
                    ->sortable(),
                // SelectColumn::make('custom_fields.gender')
                //     ->label('Gender')
                //     ->options([
                //         'Laki-laki' => 'Laki-laki',
                //         'Perempuan' => 'Perempuan',
                //     ])
                //     ->default(fn ($record) => $record->custom_fields['gender'] ?? null)
                //     ->searchable()
                //     ->sortable(),
                SelectColumn::make('status')
                    ->label('Status')
                    ->options([
                        'Active' => 'Active',
                        'Inactive' => 'Inactive',
                    ])
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                ExportHelper::excelAction('data_user', static::exportColumns()),
                ExportHelper::pdfAction('data_user', static::exportColumns(), 'Data User'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn() => auth()->user()->can('delete data')),
                ]),
            ]);
    }
}
