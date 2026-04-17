<?php

namespace App\Filament\Resources\Expertises\Tables;

use App\Filament\Concerns\ExportHelper;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExpertisesTable
{
    private static function exportColumns(): array
    {
        return [
            'name' => 'Nama Expertise',
        ];
    }

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Expertise')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                ExportHelper::excelAction('data_keahlian', static::exportColumns()),
                ExportHelper::pdfAction('data_keahlian', static::exportColumns(), 'Data Keahlian'),
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
