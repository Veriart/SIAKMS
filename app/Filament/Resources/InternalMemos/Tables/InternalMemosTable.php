<?php

namespace App\Filament\Resources\InternalMemos\Tables;

use App\Filament\Concerns\ExportHelper;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InternalMemosTable
{
    private static function exportColumns(): array
    {
        return [
            'letter_number' => 'No. Surat',
            'ref' => 'No. Referensi',
            'pic_name' => 'Nama PIC',
            'reason' => 'Keterangan/Perihal',
            'date' => 'Hari,Tanggal',
            'time' => 'Waktu',
            'place' => 'Tempat Pelaksanaan',
            'note' => 'Catatan',
        ];
    }

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('letter_number')
                    ->label('No. Surat'),
                TextColumn::make('ref')
                    ->label('No. Referensi'),
                TextColumn::make('pic_name')
                    ->label('Nama PIC'),
                TextColumn::make('reason')
                    ->label('Keterangan/Perihal'),
                TextColumn::make('date')
                    ->label('Hari,Tanggal'),
                TextColumn::make('time')
                    ->label('Waktu'),
                TextColumn::make('place')
                    ->label('Tempat Pelaksanaan'),
                TextColumn::make('note')
                    ->label('Catatan'),
                TextColumn::make('ref_file')
                    ->label('Ref File')
                    ->formatStateUsing(fn($state) => 'Ref File')
                    ->url(fn($record) => asset('storage/' . $record->ref_file))
                    ->openUrlInNewTab(),
                TextColumn::make('dispen_file')
                    ->label('Dispen File')
                    ->formatStateUsing(fn($state) => 'Dispen File')
                    ->url(fn($record) => asset('storage/' . $record->dispen_file))
                    ->openUrlInNewTab()
                    ->visible(fn() => auth()->user()?->hasRole('Super Admin')),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                ExportHelper::excelAction('data_memo_internal', static::exportColumns()),
                ExportHelper::pdfAction('data_memo_internal', static::exportColumns(), 'Data Memo Internal'),
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
