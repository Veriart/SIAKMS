<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class InternalMemo extends Model
{
    protected $fillable = [
        'user_id',
        'letter_number',
        'ref',
        'pic_name',
        'reason',
        'date',
        'time',
        'place',
        'note',
        'ref_file',
        'dispen_file',
    ];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            $now = Carbon::parse($model->date ?? now());

            $year  = $now->format('Y');
            $month = $now->format('m');

            // Konversi bulan ke Romawi
            $romanMonth = [
                1 => 'I',
                2 => 'II',
                3 => 'III',
                4 => 'IV',
                5 => 'V',
                6 => 'VI',
                7 => 'VII',
                8 => 'VIII',
                9 => 'IX',
                10 => 'X',
                11 => 'XI',
                12 => 'XII',
            ][$now->month];

            // Hitung nomor urut berdasarkan tahun & bulan
            $count = self::whereYear('date', $year)
                // ->whereMonth('date', $month)
                ->count() + 1;

            $number = str_pad($count, 3, '0', STR_PAD_LEFT);

            $model->letter_number =
                $number .
                '/Int.Memo/Akademik-Dispen/' .
                $romanMonth .
                '/' .
                $year;

            $model->user_id = auth()->user()->id;
        });
    }
}
