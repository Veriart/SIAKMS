<?php

namespace App\Filament\Resources\ExamAttendances\Schemas;

use App\Models\ScheduleExam;
use App\Models\Student;
use App\Models\Teacher;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class ExamAttendanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('schedule_exam_id')
                    ->label('Jadwal Ujian')
                    ->options(function () {
                        return ScheduleExam::with(['subject', 'academicYear'])
                            ->get()
                            ->mapWithKeys(function ($exam) {
                                $label = $exam->category . ' — ' . $exam->subject->name . ' (' . $exam->start_date->format('d/m/Y') . ')';
                                return [$exam->id => $label];
                            });
                    })
                    ->required()
                    ->searchable()
                    ->preload()
                    ->native(false),
                Select::make('student_id')
                    ->label('Siswa')
                    ->options(function () {
                        return Student::with('user')->get()->pluck('user.name', 'id');
                    })
                    ->required()
                    ->searchable()
                    ->preload()
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
            ]);
    }
}
