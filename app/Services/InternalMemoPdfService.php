<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;

class InternalMemoPdfService
{
    public function generateAndMerge($memo)
    {
        // Generate File PDF
        $pdf = Pdf::loadView('pdf.internal-memo', [
            'memo' => $memo,
        ]);

        $generatedPath = 'internal-memos/Reference/Ref_' . time() . '.pdf';
        Storage::disk('public')->put($generatedPath, $pdf->output());

        // Merge dengan ref_file
        $finalPath = 'internal-memos/Dispensation/IM_Dispensasi_' . time() . '.pdf';
        $fpdi = new Fpdi();

        // Tambahkan halaman hasil generate
        $this->importPdf(
            $fpdi,
            storage_path('app/public/' . $generatedPath)
        );

        // Tambahkan ref_file jika ada
        if ($memo->ref_file) {
            $this->importPdf(
                $fpdi,
                storage_path('app/public/' . $memo->ref_file)
            );
        }

        $fpdi->Output(
            storage_path('app/public/' . $finalPath),
            'F'
        );

        // Hapus file sementara
        Storage::disk('public')->delete($generatedPath);

        return $finalPath;
    }

    private function importPdf($fpdi, $filePath)
    {
        $pageCount = $fpdi->setSourceFile($filePath);

        for ($i = 1; $i <= $pageCount; $i++) {
            $template = $fpdi->importPage($i);
            $size = $fpdi->getTemplateSize($template);

            $fpdi->AddPage(
                $size['orientation'],
                [$size['width'], $size['height']]
            );

            $fpdi->useTemplate($template);
        }
    }
}