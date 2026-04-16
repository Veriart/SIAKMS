<?php

namespace App\Filament\Resources\ActivityInformations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ActivityInformationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Kegiatan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('execution_date')
                    ->label('Tanggal Pelaksanaan')
                    ->date('l, d F Y')
                    ->sortable(),
                TextColumn::make('execution_place')
                    ->label('Tempat Pelaksanaan')
                    ->searchable(),
                TextColumn::make('document_file')
                    ->label('Dokumen')
                    ->formatStateUsing(fn($state) => $state ? 'Lihat Dokumen' : '-')
                    ->url(fn($record) => $record->document_file ? asset('storage/' . $record->document_file) : null)
                    ->openUrlInNewTab(),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('execution_date', 'desc')
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
