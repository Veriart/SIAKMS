<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\InternalMemo;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class StatsDashboard extends BaseWidget
{
    use HasWidgetShield;

    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    public function getColumns(): int | array
    {
        return 5;
    }

    protected function getStats(): array
    {
        $student = Student::count();
        $teacher = Teacher::count();
        $classroom = Classroom::count();
        $subject = Subject::count();
        $memo = InternalMemo::count();

        return [
            Stat::make('Total Siswa', $student)
                ->description('Jumlah siswa terdaftar')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([2, 5, 8, 12, 10, 15, 20])
                ->icon('heroicon-o-users')
                ->color('primary'),

            Stat::make('Total Guru', $teacher)
                ->description('Tenaga pengajar aktif')
                ->descriptionIcon('heroicon-m-check-badge')
                ->chart([1, 2, 4, 3, 5, 4, 7])
                ->icon('heroicon-o-user')
                ->color('success'),

            Stat::make('Jumlah Kelas', $classroom)
                ->description('Ruang kelas tersedia')
                ->icon('heroicon-o-home-modern')
                ->color('warning'),

            Stat::make('Mata Pelajaran', $subject)
                ->description('Kurikulum aktif')
                ->icon('heroicon-o-book-open')
                ->color('info'),

            Stat::make('Memo Internal', $memo)
                ->description('Total memo tercatat')
                ->icon('heroicon-o-document-text')
                ->color('danger'),
        ];
    }
}
