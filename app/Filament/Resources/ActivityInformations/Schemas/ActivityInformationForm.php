<?php

namespace App\Filament\Resources\ActivityInformations\Schemas;

use App\Models\Student;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class ActivityInformationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Kegiatan')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('execution_date')
                    ->label('Tanggal Pelaksanaan')
                    ->native(false)
                    ->displayFormat('l, d F Y')
                    ->required(),
                TextInput::make('execution_place')
                    ->label('Tempat Pelaksanaan')
                    ->required()
                    ->maxLength(255),
                FileUpload::make('document_file')
                    ->label('Dokumen')
                    ->directory('activity-informations')
                    ->disk('public')
                    ->acceptedFileTypes(['application/pdf', 'image/*', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                    ->maxSize(5120),
                Select::make('target_audience')
                    ->label('Ditujukan Kepada')
                    ->options([
                        'all' => 'Semua (Guru & Siswa)',
                        'teachers' => 'Guru Saja',
                        'students' => 'Siswa',
                    ])
                    ->default('all')
                    ->required()
                    ->live()
                    ->native(false),
                Select::make('student_scope')
                    ->label('Cakupan Siswa')
                    ->options([
                        'all_students' => 'Semua Siswa',
                        'specific_classrooms' => 'Kelas Tertentu',
                    ])
                    ->required()
                    ->live()
                    ->native(false)
                    ->visible(fn(Get $get): bool => $get('target_audience') === 'students'),
                Select::make('classrooms')
                    ->label('Pilih Kelas')
                    ->multiple()
                    ->options(function () {
                        return Student::with(['classroom', 'expertise'])
                            ->get()
                            ->unique(fn($s) => $s->classroom_id . '_' . $s->expertise_id)
                            ->sortBy(fn($s) => $s->classroom->name . ' ' . ($s->expertise->name ?? ''))
                            ->mapWithKeys(function ($student) {
                                $label = trim($student->classroom->name . ' ' . ($student->expertise->name ?? ''));
                                $key   = $student->classroom_id . '_' . $student->expertise_id; // ← $s diganti $student
                                return [$key => $label];
                            });
                    })
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->required()
                    ->visible(fn(Get $get): bool => $get('target_audience') === 'students' && $get('student_scope') === 'specific_classrooms')

                    // Simpan: sync pivot dengan KEDUA kolom classroom_id + expertise_id
                    ->saveRelationshipsUsing(function ($component, $record, $state) {
                        // Hapus semua pivot lama dulu
                        $record->classrooms()->detach();

                        // Insert ulang satu per satu
                        collect($state ?? [])->each(function ($key) use ($record) {
                            [$classroomId, $expertiseId] = explode('_', $key);
                            $record->classrooms()->attach((int) $classroomId, [
                                'expertise_id' => (int) $expertiseId,
                            ]);
                        });
                    })

                    // Muat: bangun composite key dari pivot yang menyimpan expertise_id
                    ->loadStateFromRelationshipsUsing(function ($component, $record) {
                        $keys = $record->classrooms()
                            ->withPivot('expertise_id')        // ← ambil expertise_id dari pivot
                            ->get()
                            ->map(fn($classroom) => $classroom->id . '_' . $classroom->pivot->expertise_id)
                            ->values()
                            ->toArray();

                        $component->state($keys);
                    }),
            ]);
    }
}
