<?php

namespace App\Filament\Resources\ActivityInformations\Tables;

use App\Filament\Concerns\ExportHelper;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ActivityInformationsTable
{
    private static function exportColumns(): array
    {
        return [
            'name' => 'Nama Kegiatan',
            'execution_date' => 'Tanggal Pelaksanaan',
            'execution_place' => 'Tempat Pelaksanaan',
            'target_audience' => 'Ditujukan Kepada',
            'created_at' => 'Dibuat',
        ];
    }

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
                TextColumn::make('target_audience')
                    ->label('Ditujukan Kepada')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'all' => 'Semua',
                        'teachers' => 'Guru',
                        'students' => 'Siswa',
                        default => '-',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'all' => 'primary',
                        'teachers' => 'success',
                        'students' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('target_label')
                    ->label('Detail Target')
                    ->getStateUsing(function ($record) {
                        if ($record->target_audience === 'all') {
                            return 'Semua (Guru & Siswa)';
                        }
                        if ($record->target_audience === 'teachers') {
                            return 'Guru Saja';
                        }
                        if ($record->student_scope === 'all_students') {
                            return 'Semua Siswa';
                        }
                        // Specific classrooms - tampilkan detail dengan expertise
                        $classroomDetails = $record->classrooms()
                            ->withPivot('expertise_id')
                            ->get()
                            ->map(function ($classroom) {
                                $expertise = $classroom->pivot->expertise_id
                                    ? \App\Models\Expertise::find($classroom->pivot->expertise_id)
                                    : null;
                                return trim($classroom->name . ' ' . ($expertise->name ?? ''));
                            })
                            ->join(', ');
                        return $classroomDetails ?: '-';
                    })
                    ->wrap(),
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
            ->headerActions([
                ExportHelper::excelAction('data_kegiatan', static::exportColumns()),
                ExportHelper::pdfAction('data_kegiatan', static::exportColumns(), 'Data Kegiatan'),
            ])
            ->recordActions([
                EditAction::make()
                    ->visible(fn() => auth()->user()->can('update data')),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn() => auth()->user()->can('delete data')),
                ]),
            ]);
    }
}
