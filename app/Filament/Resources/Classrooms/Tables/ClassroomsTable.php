<?php

namespace App\Filament\Resources\Classrooms\Tables;

use App\Filament\Concerns\ExportHelper;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;

class ClassroomsTable
{
    private static function exportColumns(): array
    {
        return [
            'name' => 'Nama Kelas',
        ];
    }

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Kelas')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                ExportHelper::excelAction('data_kelas', static::exportColumns()),
                ExportHelper::pdfAction('data_kelas', static::exportColumns(), 'Data Kelas'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn() => auth()->user()->can('delete data')),
                ]),
            ]);
    }
}
