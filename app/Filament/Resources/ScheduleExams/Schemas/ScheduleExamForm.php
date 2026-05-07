<?php

namespace App\Filament\Resources\ScheduleExams\Schemas;

use App\Models\Student;
use App\Models\Teacher;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class ScheduleExamForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category')
                    ->label('Kategori')
                    ->options([
                        'ASAS B1' => 'ASAS B1',
                        'ASAT B1' => 'ASAT B1',
                        'ASAS B2' => 'ASAS B2',
                        'ASAT B2' => 'ASAT B2',
                        'ASAJ' => 'ASAJ',
                    ])
                    ->required()
                    ->native(false),
                Select::make('academic_year_id')
                    ->label('Tahun Akademik')
                    ->relationship('academicYear', 'in')
                    ->required()
                    ->native(false),
                Select::make('subject_id')
                    ->label('Mata Pelajaran')
                    ->relationship('subject', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->native(false),
                Select::make('type')
                    ->label('Tipe')
                    ->options([
                        'Lv. 1' => 'Lv. 1',
                        'Lv. 2' => 'Lv. 2',
                        'Lv. 3' => 'Lv. 3',
                        'A2 Flyers' => 'A2 Flyers',
                        'A2 Key' => 'A2 Key',
                        'B1' => 'B1',
                    ])
                    ->native(false),
                Select::make('teacher_id')
                    ->label('Pengawas')
                    ->options(function () {
                        return Teacher::with('user')->get()->pluck('user.name', 'id');
                    })
                    ->required()
                    ->searchable()
                    ->preload()
                    ->native(false),
                DatePicker::make('start_date')
                    ->label('Tanggal Mulai')
                    ->native(false)
                    ->displayFormat('l, d F Y')
                    ->required(),
                DatePicker::make('end_date')
                    ->label('Tanggal Selesai')
                    ->native(false)
                    ->displayFormat('l, d F Y')
                    ->required()
                    ->afterOrEqual('start_date'),
                Select::make('target_class_level')
                    ->label('Target Kelas')
                    ->options([
                        'all' => 'Semua Kelas',
                        'X' => 'Kelas X',
                        'XI' => 'Kelas XI',
                        'XII' => 'Kelas XII',
                    ])
                    ->default('all')
                    ->required()
                    ->live()
                    ->native(false),
                Select::make('class_scope')
                    ->label('Cakupan Jurusan')
                    ->options([
                        'all_classes' => 'Semua Jurusan',
                        'specific_classrooms' => 'Jurusan Tertentu',
                    ])
                    ->required()
                    ->live()
                    ->native(false)
                    ->visible(fn(Get $get): bool => in_array($get('target_class_level'), ['X', 'XI', 'XII'])),
                Select::make('classrooms')
                    ->label('Pilih Kelas')
                    ->multiple()
                    ->options(function (Get $get) {
                        $level = $get('target_class_level');

                        return Student::with(['classroom', 'expertise'])
                            ->whereHas('classroom', function ($query) use ($level) {
                                $query->where('name', 'LIKE', $level . '%');
                            })
                            ->get()
                            ->unique(fn($s) => $s->classroom_id . '_' . $s->expertise_id)
                            ->sortBy(fn($s) => $s->classroom->name . ' ' . ($s->expertise->name ?? ''))
                            ->mapWithKeys(function ($student) {
                                $label = trim($student->classroom->name . ' ' . ($student->expertise->name ?? ''));
                                $key   = $student->classroom_id . '_' . $student->expertise_id;
                                return [$key => $label];
                            });
                    })
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->required()
                    ->visible(fn(Get $get): bool => in_array($get('target_class_level'), ['X', 'XI', 'XII']) && $get('class_scope') === 'specific_classrooms')

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
                            ->withPivot('expertise_id')
                            ->get()
                            ->map(fn($classroom) => $classroom->id . '_' . $classroom->pivot->expertise_id)
                            ->values()
                            ->toArray();

                        $component->state($keys);
                    }),
            ]);
    }
}
