<?php

namespace App\Filament\Widgets;

use App\Models\InternalMemo;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class LatestInternalMemos extends BaseWidget
{
    use HasWidgetShield;

    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Memo Internal Terkini';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                InternalMemo::query()->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('letter_number')
                    ->label('Nomor Surat')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('pic_name')
                    ->label('PIC')
                    ->searchable(),
                Tables\Columns\TextColumn::make('reason')
                    ->label('Kegiatan')
                    ->wrap()
                    ->limit(50),
                Tables\Columns\TextColumn::make('date')
                    ->label('Tanggal Surat')
                    // Memastikan kita punya accessor atau custom cast date, atau biarkan string 
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->paginated(false);
    }
}
