<?php

namespace App\Filament\Resources\Teachers\Schemas;

use App\Helpers\ClassroomOptions;
use App\Models\AcademicYear;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TeacherForm
{
    /**
     * Format tahun akademik: "2025 - 2026"
     */
    private static function academicYearOptions(): array
    {
        return AcademicYear::orderBy('in', 'desc')
            ->get()
            ->mapWithKeys(fn ($ay) => [
                $ay->id => $ay->in . ' - ' . ($ay->in + 1),
            ])
            ->toArray();
    }

    /**
     * Opsi nama dokumen umum yang sering dibutuhkan guru.
     */
    private static function documentNameOptions(): array
    {
        return [
            'KTP' => 'KTP',
            'Kartu Keluarga' => 'Kartu Keluarga',
            'Ijazah SMA/SMK' => 'Ijazah SMA/SMK',
            'Ijazah D3' => 'Ijazah D3',
            'Ijazah D4' => 'Ijazah D4',
            'Ijazah S1' => 'Ijazah S1',
            'Ijazah S2' => 'Ijazah S2',
            'Ijazah S3' => 'Ijazah S3',
            'Transkrip Nilai' => 'Transkrip Nilai',
            'Sertifikat Pendidik' => 'Sertifikat Pendidik',
            'SK Pengangkatan' => 'SK Pengangkatan',
            'SKCK' => 'SKCK',
            'Surat Keterangan Sehat' => 'Surat Keterangan Sehat',
            'NPWP' => 'NPWP',
            'BPJS' => 'BPJS',
            'Pas Foto' => 'Pas Foto',
            'Lainnya' => 'Lainnya',
        ];
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Pribadi')
                    ->icon('heroicon-o-user')
                    ->collapsible()
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label('Nama Lengkap')
                                // ->disabled()
                                ->dehydrated()
                                ->afterStateHydrated(fn ($component, $record) => $component->state($record?->user?->name)),
                            TextInput::make('identification_number')
                                ->label('NIP')
                                ->required()
                                ->maxLength(30),
                            TextInput::make('nuptk')
                                ->label('NUPTK')
                                ->maxLength(30),
                            Select::make('gender')
                                ->label('Jenis Kelamin')
                                ->options([
                                    'Laki-laki' => 'Laki-laki',
                                    'Perempuan' => 'Perempuan',
                                ])
                                ->required()
                                ->native(false),
                            Select::make('religion')
                                ->label('Agama')
                                ->options([
                                    'Islam' => 'Islam',
                                    'Kristen' => 'Kristen',
                                    'Katolik' => 'Katolik',
                                    'Hindu' => 'Hindu',
                                    'Buddha' => 'Buddha',
                                ])
                                ->required()
                                ->native(false),
                            TextInput::make('place_of_birth')
                                ->label('Tempat Lahir')
                                ->maxLength(100),
                            DatePicker::make('date_of_birth')
                                ->label('Tanggal Lahir')
                                ->native(false)
                                ->displayFormat('d F Y'),
                            TextInput::make('phone')
                                ->label('No. Telepon')
                                ->tel()
                                ->maxLength(20),
                        ]),
                        Textarea::make('address')
                            ->label('Alamat')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Section::make('Informasi Kepegawaian')
                    ->icon('heroicon-o-briefcase')
                    ->collapsible()
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('education_level')
                                ->label('Jenjang Pendidikan')
                                ->options([
                                    'SMA' => 'SMA/SMK',
                                    'D3' => 'D3',
                                    'D4' => 'D4',
                                    'S1' => 'S1',
                                    'S2' => 'S2',
                                    'S3' => 'S3',
                                ])
                                ->native(false),
                            TextInput::make('education_major')
                                ->label('Jurusan Pendidikan')
                                ->maxLength(100),
                            TextInput::make('position')
                                ->label('Jabatan')
                                ->maxLength(100),
                            DatePicker::make('join_date')
                                ->label('Tanggal Bergabung')
                                ->native(false)
                                ->displayFormat('d F Y'),
                            Select::make('status')
                                ->label('Status')
                                ->options([
                                    'Active' => 'Aktif',
                                    'Inactive' => 'Tidak Aktif',
                                ])
                                ->default('Active')
                                ->required()
                                ->native(false),
                        ]),
                    ]),

                Section::make('Berkas Dokumen')
                    ->icon('heroicon-o-document-arrow-up')
                    ->description('Upload berkas kebutuhan guru: KTP, KK, Ijazah, Sertifikat, dll.')
                    ->collapsible()
                    ->schema([
                        Repeater::make('documents')
                            ->label('')
                            ->relationship()
                            ->schema([
                                Grid::make(12)->schema([
                                    Select::make('document_name')
                                        ->label('Jenis Dokumen')
                                        ->options(static::documentNameOptions())
                                        ->required()
                                        ->searchable()
                                        ->native(false)
                                        ->columnSpan(4),
                                    FileUpload::make('file_path')
                                        ->label('File')
                                        ->directory('teacher-documents')
                                        ->acceptedFileTypes([
                                            'application/pdf',
                                            'image/jpeg',
                                            'image/png',
                                            'image/webp',
                                        ])
                                        ->maxSize(5120) // 5MB
                                        ->openable()
                                        ->downloadable()
                                        ->previewable()
                                        ->columnSpan(5),
                                    Textarea::make('notes')
                                        ->label('Catatan')
                                        ->rows(1)
                                        ->placeholder('Opsional')
                                        ->columnSpan(3),
                                ]),
                            ])
                            ->defaultItems(0)
                            ->addActionLabel('+ Tambah Dokumen')
                            ->reorderable(false)
                            ->columns(1),
                    ]),

                Section::make('Penugasan Mengajar')
                    ->icon('heroicon-o-academic-cap')
                    ->description('Daftar mata pelajaran dan kelas yang diajar beserta jumlah jam per minggu')
                    ->collapsible()
                    ->schema([
                        Repeater::make('teachingAssignments')
                            ->label('')
                            ->relationship()
                            ->schema([
                                Grid::make(6)->schema([
                                    Select::make('academic_year_id')
                                    ->label('Tahun Akademik')
                                    ->options(static::academicYearOptions())
                                    ->required()
                                    ->native(false)
                                    ->columnSpan(3),
                                    Select::make('subject_id')
                                        ->label('Mata Pelajaran')
                                        ->relationship('subject', 'name')
                                        ->required()
                                        ->searchable()
                                        ->preload()
                                        ->native(false)
                                        ->columnSpan(3),
                                    ]),
                                    Grid::make(6)->schema([
                                        Select::make('classroom_expertise')
                                            ->label('Kelas')
                                            ->options(fn () => ClassroomOptions::all())
                                            ->required()
                                            ->searchable()
                                            ->preload()
                                            ->native(false)
                                            ->columnSpan(4)
                                            ->afterStateHydrated(function ($component, $record) {
                                                if ($record && $record->classroom_id) {
                                                    $component->state($record->classroom_id . '_' . ($record->expertise_id ?? ''));
                                                }
                                            })
                                            ->dehydrated(false)
                                            ->afterStateUpdated(function ($state, $set) {
                                                if ($state && str_contains($state, '_')) {
                                                    [$classroomId, $expertiseId] = explode('_', $state);
                                                    $set('classroom_id', (int) $classroomId);
                                                    $set('expertise_id', $expertiseId ? (int) $expertiseId : null);
                                                }
                                            })
                                            ->live(),
                                            TextInput::make('hours_per_week')
                                            ->label('Jam/Minggu')
                                            ->numeric()
                                            ->required()
                                            ->default(0)
                                            ->minValue(0)
                                            ->suffix('jam')
                                            ->columnSpan(2),
                                    ]),
                                Hidden::make('classroom_id'),
                                Hidden::make('expertise_id'),
                            ])
                            ->defaultItems(0)
                            ->addActionLabel('+ Tambah Penugasan Mengajar')
                            ->reorderable(false)
                            ->columns(1)
                            ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                                if (empty($data['classroom_id']) && !empty($data['classroom_expertise'])) {
                                    [$classroomId, $expertiseId] = explode('_', $data['classroom_expertise']);
                                    $data['classroom_id'] = (int) $classroomId;
                                    $data['expertise_id'] = $expertiseId ? (int) $expertiseId : null;
                                }
                                unset($data['classroom_expertise']);
                                return $data;
                            })
                            ->mutateRelationshipDataBeforeSaveUsing(function (array $data): array {
                                if (empty($data['classroom_id']) && !empty($data['classroom_expertise'])) {
                                    [$classroomId, $expertiseId] = explode('_', $data['classroom_expertise']);
                                    $data['classroom_id'] = (int) $classroomId;
                                    $data['expertise_id'] = $expertiseId ? (int) $expertiseId : null;
                                }
                                unset($data['classroom_expertise']);
                                return $data;
                            }),
                    ]),

                Section::make('Tugas Tambahan')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->description('Tugas tambahan selain mengajar, seperti koordinator, waka kurikulum, dll.')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Repeater::make('additionalDuties')
                            ->label('')
                            ->relationship()
                            ->schema([
                                Grid::make(6)->schema([
                                    Select::make('academic_year_id')
                                    ->label('Tahun Akademik')
                                    ->options(static::academicYearOptions())
                                    ->required()
                                    ->native(false)
                                    ->columnSpan(3),
                                    TextInput::make('duty_name')
                                    ->label('Nama Tugas')
                                    ->required()
                                    ->placeholder('cth: Waka Kurikulum, Koordinator Pembelajaran')
                                    ->maxLength(255)
                                    ->columnSpan(3),
                                ]),
                                Grid::make(6)->schema([
                                    Textarea::make('description')
                                    ->label('Keterangan')
                                    ->rows(1)
                                    ->placeholder('Opsional')
                                    ->columnSpan(6),
                                ]),
                            ])
                            ->defaultItems(0)
                            ->addActionLabel('+ Tambah Tugas Tambahan')
                            ->reorderable(false)
                            ->columns(1),
                    ]),
            ]);
    }
}
