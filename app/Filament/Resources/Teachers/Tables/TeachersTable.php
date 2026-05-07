<?php

namespace App\Filament\Resources\Teachers\Tables;

use App\Filament\Concerns\ExportHelper;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

class TeachersTable
{
    private static function exportColumns(): array
    {
        return [
            'user.name' => 'Nama',
            'identification_number' => 'NIP',
            'nuptk' => 'NUPTK',
            'gender' => 'Jenis Kelamin',
            'religion' => 'Agama',
            'education_level' => 'Jenjang Pendidikan',
            'position' => 'Jabatan',
            'status' => 'Status',
        ];
    }

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('identification_number')
                    ->label('NIP')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('nuptk')
                    ->label('NUPTK')
                    ->sortable()
                    ->searchable()
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('gender')
                    ->label('Jenis Kelamin')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('religion')
                    ->label('Agama')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('position')
                    ->label('Jabatan')
                    ->placeholder('-')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('subjects_taught')
                    ->label('Mata Pelajaran')
                    ->getStateUsing(function ($record) {
                        $subjects = $record->teachingAssignments()
                            ->with('subject')
                            ->get()
                            ->pluck('subject.name')
                            ->unique()
                            ->filter()
                            ->values();

                        return $subjects->isNotEmpty() ? $subjects->join(', ') : '-';
                    })
                    ->wrap()
                    ->searchable(false),
                TextColumn::make('teaching_detail')
                    ->label('Detail Mengajar')
                    ->getStateUsing(function ($record) {
                        $assignments = $record->teachingAssignments()
                            ->with(['subject', 'classroom', 'expertise'])
                            ->get();

                        if ($assignments->isEmpty()) {
                            return '-';
                        }

                        return $assignments->map(function ($a) {
                            $classLabel = trim(($a->classroom->name ?? '') . ' ' . ($a->expertise->name ?? ''));
                            return ($a->subject->name ?? '-') . ' → ' . $classLabel . ' (' . $a->hours_per_week . ' jam)';
                        })->join(', ');
                    })
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('total_hours')
                    ->label('Total Jam/Minggu')
                    ->getStateUsing(function ($record) {
                        $total = $record->teachingAssignments()->sum('hours_per_week');
                        return $total > 0 ? $total . ' jam' : '-';
                    })
                    ->badge()
                    ->color(fn (string $state): string => $state === '-' ? 'gray' : 'success')
                    ->sortable(false),
                TextColumn::make('additional_duties_label')
                    ->label('Tugas Tambahan')
                    ->getStateUsing(function ($record) {
                        $duties = $record->additionalDuties()
                            ->with('academicYear')
                            ->get();

                        if ($duties->isEmpty()) {
                            return '-';
                        }

                        return $duties->map(function ($d) {
                            $year = $d->academicYear ? $d->academicYear->in . '-' . ($d->academicYear->in + 1) : '';
                            return $d->duty_name . ' (' . $year . ')';
                        })->join(', ');
                    })
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true),
                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'Active',
                        'danger' => 'Inactive',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'Active' => 'Aktif',
                        'Inactive' => 'Tidak Aktif',
                        default => $state,
                    })
                    ->default('Active')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                ExportHelper::excelAction('data_guru', static::exportColumns()),
                ExportHelper::pdfAction('data_guru', static::exportColumns(), 'Data Guru'),
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
