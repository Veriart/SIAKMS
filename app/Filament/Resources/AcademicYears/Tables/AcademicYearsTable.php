<?php

namespace App\Filament\Resources\AcademicYears\Tables;

use App\Filament\Concerns\ExportHelper;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;

class AcademicYearsTable
{
    private static function exportColumns(): array
    {
        return [
            'in' => 'Tahun Masuk',
            'out' => 'Tahun Keluar',
        ];
    }

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('in')
                    ->label('Tahun Masuk')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('out')
                    ->label('Tahun Keluar')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                ExportHelper::excelAction('data_tahun_akademik', static::exportColumns()),
                ExportHelper::pdfAction('data_tahun_akademik', static::exportColumns(), 'Data Tahun Akademik'),
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
