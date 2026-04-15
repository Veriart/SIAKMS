<?php

namespace App\Filament\Resources\TeacherAdministrations\Schemas;

use App\Models\AcademicYear;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TeacherAdministrationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Adm')
                    ->required(),
                Select::make('category')
                    ->label('Kategori Adm')
                    ->options([
                        'Jurnal' => 'Jurnal',
                        'Prota' => 'Prota',
                        'Prosem' => 'Prosem',
                        'CP' => 'CP',
                        'ATP' => 'ATP'
                    ])
                    ->required(),
                Select::make('academic_year_id')
                    ->label('Tahun Pelajaran')
                    ->options(
                        AcademicYear::all()->mapWithKeys(function ($item) {
                            return [
                                $item->id => $item->in . '-' . $item->out
                            ];
                        })->toArray()
                    )
                    ->required(),
                Select::make('semester')
                    ->label('Semester')
                    ->options([
                        'Ganjil' => 'Ganjil',
                        'Genap' => 'Genap'
                    ])
                    ->required(),
                FileUpload::make('file')
                    ->label('File ADM')
                    ->directory('teacher-administration')
                    ->disk('public')
                    ->required(),
            ]);
    }
}
