<?php

namespace App\Filament\Resources\ScheduleExams\Tables;

use App\Filament\Concerns\ExportHelper;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ScheduleExamsTable
{
    private static function exportColumns(): array
    {
        return [
            'category' => 'Kategori',
            'academicYear.in' => 'Tahun Akademik',
            'subject.name' => 'Mata Pelajaran',
            'type' => 'Tipe',
            'teacher.user.name' => 'Pengawas',
            'start_date' => 'Tanggal Mulai',
            'end_date' => 'Tanggal Selesai',
        ];
    }

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'ASAS B1' => 'primary',
                        'ASAT B1' => 'success',
                        'ASAS B2' => 'warning',
                        'ASAT B2' => 'danger',
                        'ASAJ' => 'info',
                        default => 'gray',
                    })
                    ->sortable()
                    ->searchable(),
                TextColumn::make('academicYear.in')
                    ->label('Tahun Akademik')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('subject.name')
                    ->label('Mata Pelajaran')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color('gray')
                    ->sortable()
                    ->searchable()
                    ->placeholder('-'),
                TextColumn::make('teacher.user.name')
                    ->label('Pengawas')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('start_date')
                    ->label('Tanggal Mulai')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('Tanggal Selesai')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('target_label')
                    ->label('Detail Target')
                    ->getStateUsing(function ($record) {
                        if ($record->target_class_level === 'all' || empty($record->target_class_level)) {
                            return 'Semua Kelas';
                        }

                        $level = $record->target_class_level;

                        if ($record->class_scope === 'all_classes') {
                            return "Kelas {$level} (Semua Jurusan)";
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
                    ->wrap()
                    ->badge()
                    ->separator(',')
                    ->color('info'),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('start_date', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                ExportHelper::excelAction('jadwal_ujian', static::exportColumns()),
                ExportHelper::pdfAction('jadwal_ujian', static::exportColumns(), 'Jadwal Ujian'),
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
