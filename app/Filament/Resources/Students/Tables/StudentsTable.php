<?php

namespace App\Filament\Resources\Students\Tables;

use App\Filament\Concerns\ExportHelper;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Collection;

class StudentsTable
{
    private static function exportColumns(): array
    {
        return [
            'user.name' => 'Nama',
            'student_number' => 'No. Induk',
            'classroom.name' => 'Kelas',
            'expertise.name' => 'Keahlian',
            'academicYear.in' => 'Tahun Akademik',
            'gender' => 'Jenis Kelamin',
            'religion' => 'Agama',
            'status' => 'Status',
            'exam_access' => 'Akses Ujian',
        ];
    }

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('student_number')
                    ->label('No. Induk')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('classroom.name')
                    ->label('Classroom')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('expertise.name')
                    ->label('Expertise')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('academicYear.in')
                    ->label('Academic Year')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('gender')
                    ->label('Gender')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('religion')
                    ->label('Religion')
                    ->sortable()
                    ->searchable(),
                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'Student',
                        'danger' => 'Alumni',
                    ])
                    ->default('Student')
                    ->sortable()
                    ->searchable(),
                ToggleColumn::make('exam_access')
                    ->label('Akses Ujian')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                ExportHelper::excelAction('data_siswa', static::exportColumns()),
                ExportHelper::pdfAction('data_siswa', static::exportColumns(), 'Data Siswa'),
            ])
            ->recordActions([
                Action::make('kartu_ujian')
                    ->label('Kartu Ujian')
                    ->icon('heroicon-o-identification')
                    ->url(fn($record) => route('kartu.ujian', $record))
                    ->openUrlInNewTab(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('aktifkan_akses_ujian')
                        ->label('Aktifkan Akses Ujian')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn(Collection $records) => $records->each->update(['exam_access' => true]))
                        ->deselectRecordsAfterCompletion()
                        ->visible(fn() => auth()->user()->hasRole(['Finance', 'Academic', 'Super Admin'])),
                    BulkAction::make('nonaktifkan_akses_ujian')
                        ->label('Nonaktifkan Akses Ujian')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(fn(Collection $records) => $records->each->update(['exam_access' => false]))
                        ->deselectRecordsAfterCompletion()
                        ->visible(fn() => auth()->user()->hasRole(['Finance', 'Academic', 'Super Admin'])),
                    DeleteBulkAction::make()
                        ->visible(fn() => auth()->user()->can('delete data')),
                ]),
            ]);
    }
}
