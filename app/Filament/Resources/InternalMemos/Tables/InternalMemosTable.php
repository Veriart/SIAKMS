<?php

namespace App\Filament\Resources\InternalMemos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InternalMemosTable
{
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
                    ->openUrlInNewTab(),
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
