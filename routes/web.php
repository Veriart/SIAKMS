<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SheetImportController;

Route::get('/', function () {
    return redirect('/app/login');
});

Route::get('/data/sync-sheet', [SheetImportController::class, 'sync']);
Route::get('/data/urole', [SheetImportController::class, 'urole']);

// Kartu Ujian - menggunakan slug agar ID tidak terlihat
Route::get('/kartu-ujian/{student:slug}', function (\App\Models\Student $student) {
    return view('pdf.kartu-ujian', compact('student'));
})->name('kartu.ujian');
