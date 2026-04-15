<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use Filament\Widgets\ChartWidget;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class ChartDashboard extends ChartWidget
{
    use HasWidgetShield;

    protected ?string $heading = 'Distribusi Siswa Berdasarkan Jurusan';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $pplg = Student::whereIn('expertise_id', [8, 9])->count();
        $dkv = Student::whereIn('expertise_id', [6, 7])->count();
        $hotel = Student::whereIn('expertise_id', [4, 5])->count();
        $culinary = Student::whereIn('expertise_id', [2, 3])->count();
        $accountancy = Student::where('expertise_id', 1)->count();
        return [
            'datasets' => [
                [
                    'data' => [$pplg, $dkv, $hotel, $culinary, $accountancy],
                    'backgroundColor' => [
                        'rgba(252, 0, 55, 0.8)',
                        'rgba(86, 39, 255, 0.8)',
                        'rgba(45, 221, 252, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)',
                    ],
                ],
            ],
            'labels' => ['PPLG', 'DKV', 'Hotel', 'Culinary', 'Akuntansi'],
        ];
    }

    protected function getType(): string
    {
        return 'polarArea';
    }
}
