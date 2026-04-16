<?php

namespace App\Filament\Widgets;

use App\Models\ActivityInformation;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class LatestActivityInformations extends BaseWidget
{
    use HasWidgetShield;

    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 1;
    protected static ?string $heading = 'Informasi Kegiatan Terkini';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ActivityInformation::query()->latest('execution_date')->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Kegiatan')
                    ->searchable()
                    ->wrap()
                    ->limit(50),
                Tables\Columns\TextColumn::make('execution_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('execution_place')
                    ->label('Tempat')
                    ->limit(30),
                Tables\Columns\TextColumn::make('document_file')
                    ->label('Dokumen')
                    ->formatStateUsing(fn($state) => $state ? 'Document File' : '-')
                    ->url(fn($record) => $record->document_file ? asset('storage/' . $record->document_file) : null)
                    ->openUrlInNewTab(),
            ])
            ->paginated(false);
    }
}
