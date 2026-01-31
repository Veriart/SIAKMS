<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SheetImportController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/data/sync-sheet', [SheetImportController::class, 'sync']);
