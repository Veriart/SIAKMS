<?php

namespace App\Filament\Resources\AcademicAdministrations\Tables;

use App\Filament\Concerns\ExportHelper;
use App\Models\AcademicYear;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AcademicAdministrationsTable
{
    private static function exportColumns(): array
    {
        return [
            'name' => 'Administrasi',
            'academicYear.in' => 'Tahun Pelajaran',
            'semester' => 'Semester',
        ];
    }

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // TextColumn::make('user.name')
                //     ->label('Guru')
                //     ->searchable(),
                TextColumn::make('name')
                    ->label('Administrasi')
                    ->searchable(),
                SelectColumn::make('academic_year_id')
                    ->label('Tahun Pelajaran')
                    ->options(
                        AcademicYear::all()->mapWithKeys(function ($item) {
                            return [
                                $item->id => $item->in . '-' . $item->out
                            ];
                        })->toArray()
                    )
                    ->searchable(),
                SelectColumn::make('semester')
                    ->label('Semester')
                    ->options([
                        'Ganjil' => 'Ganjil',
                        'Genap' => 'Genap',
                    ])
                    ->searchable(),
                TextColumn::make('file')
                    ->label('File ADM')
                    ->formatStateUsing(fn($state) => 'File ADM')
                    ->url(fn($record) => asset('storage/' . $record->file))
                    ->openUrlInNewTab(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                ExportHelper::excelAction('data_adm_akademik', static::exportColumns()),
                ExportHelper::pdfAction('data_adm_akademik', static::exportColumns(), 'Data Administrasi Akademik'),
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
