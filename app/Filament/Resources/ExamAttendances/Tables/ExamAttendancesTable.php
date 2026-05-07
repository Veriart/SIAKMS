<?php

namespace App\Filament\Resources\ExamAttendances\Tables;

use App\Filament\Concerns\ExportHelper;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExamAttendancesTable
{
    private static function exportColumns(): array
    {
        return [
            'student.user.name' => 'Nama Siswa',
            'scheduleExam.category' => 'Kategori',
            'scheduleExam.subject.name' => 'Mata Pelajaran',
            'scheduleExam.start_date' => 'Tanggal Ujian',
            'teacher.user.name' => 'Pengawas',
            'created_at' => 'Dicatat Pada',
        ];
    }

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.user.name')
                    ->label('Nama Siswa')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('student.classroom.name')
                    ->label('Kelas')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('scheduleExam.category')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'ASAS B1' => 'primary',
                        'ASAT B1' => 'success',
                        'ASAS B2' => 'warning',
                        'ASAT B2' => 'danger',
                        'ASAJ' => 'info',
                        default => 'gray',
                    })
                    ->sortable()
                    ->searchable(),
                TextColumn::make('scheduleExam.subject.name')
                    ->label('Mata Pelajaran')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('scheduleExam.start_date')
                    ->label('Tanggal Ujian')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('teacher.user.name')
                    ->label('Pengawas')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Dicatat Pada')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                ExportHelper::excelAction('kehadiran_ujian', static::exportColumns()),
                ExportHelper::pdfAction('kehadiran_ujian', static::exportColumns(), 'Kehadiran Ujian'),
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
