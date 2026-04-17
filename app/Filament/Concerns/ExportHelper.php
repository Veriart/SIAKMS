<?php

namespace App\Filament\Concerns;

use App\Exports\TableExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;

class ExportHelper
{
    /**
     * Create an Excel export header action.
     *
     * @param string $filename   Base filename (without extension)
     * @param array  $columns    ['db_column' => 'Label', ...]
     */
    public static function excelAction(string $filename, array $columns): Action
    {
        return Action::make('export_excel')
            ->label('Export Excel')
            ->icon('heroicon-o-arrow-down-tray')
            ->color('success')
            ->action(function ($livewire) use ($filename, $columns) {
                $query = $livewire->getFilteredTableQuery();
                $records = $query->get();

                $headings = array_values($columns);
                $keys = array_keys($columns);

                $data = $records->map(function ($record) use ($keys) {
                    return collect($keys)->map(function ($key) use ($record) {
                        return static::resolveValue($record, $key);
                    })->toArray();
                });

                return Excel::download(
                    new TableExport(collect($data), $headings),
                    $filename . '_' . date('Y-m-d_His') . '.xlsx'
                );
            });
    }

    /**
     * Create a PDF export header action.
     *
     * @param string $filename   Base filename (without extension)
     * @param array  $columns    ['db_column' => 'Label', ...]
     * @param string $title      Title shown on the PDF
     */
    public static function pdfAction(string $filename, array $columns, string $title = 'Export Data'): Action
    {
        return Action::make('export_pdf')
            ->label('Export PDF')
            ->icon('heroicon-o-document-arrow-down')
            ->color('danger')
            ->action(function ($livewire) use ($filename, $columns, $title) {
                $query = $livewire->getFilteredTableQuery();
                $records = $query->get();

                $headings = array_values($columns);
                $keys = array_keys($columns);

                $rows = $records->map(function ($record) use ($keys) {
                    return collect($keys)->map(function ($key) use ($record) {
                        return static::resolveValue($record, $key);
                    })->toArray();
                })->toArray();

                $pdf = Pdf::loadView('exports.table-export-pdf', [
                    'title' => $title,
                    'headings' => $headings,
                    'rows' => $rows,
                ])->setPaper('a4', 'landscape');

                return response()->streamDownload(function () use ($pdf) {
                    echo $pdf->output();
                }, $filename . '_' . date('Y-m-d_His') . '.pdf');
            });
    }

    /**
     * Resolve a dot-notated key on a model (e.g. 'user.name', 'classroom.name').
     */
    protected static function resolveValue($record, string $key): mixed
    {
        $segments = explode('.', $key);
        $value = $record;

        foreach ($segments as $segment) {
            if (is_null($value)) {
                return '-';
            }
            $value = $value->{$segment} ?? null;
        }

        if (is_bool($value)) {
            return $value ? 'Ya' : 'Tidak';
        }

        return $value ?? '-';
    }
}
