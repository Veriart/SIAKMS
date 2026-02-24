<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SheetImportController;

Route::get('/', function () {
    return redirect('/app/login');
});

Route::get('/data/sync-sheet', [SheetImportController::class, 'sync']);
Route::get('/data/urole', [SheetImportController::class, 'urole']);
