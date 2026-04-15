<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use Filament\Widgets\ChartWidget;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class StudentGenderChart extends ChartWidget
{
    use HasWidgetShield;

    protected ?string $heading = 'Distribusi Siswa Berdasarkan Gender';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $laki = Student::where('gender', 'Laki-laki')->count();
        $perempuan = Student::where('gender', 'Perempuan')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Siswa',
                    'data' => [$laki, $perempuan],
                    'backgroundColor' => [
                        'rgba(59, 130, 246, 0.8)', // blue-500
                        'rgba(236, 72, 153, 0.8)', // pink-500
                    ],
                ],
            ],
            'labels' => ['Laki-laki', 'Perempuan'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
