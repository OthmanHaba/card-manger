<?php

use App\Http\Controllers\PrintInvoiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/print/invoice/full/{card}', [PrintInvoiceController::class, 'printFull'])
    ->name('print.full.invoice')
    ->middleware('auth'); // Assuming authentication is needed

Route::get('/print/invoice/small/{card}', [PrintInvoiceController::class, 'printSmall'])
    ->name('print.small.invoice')
    ->middleware('auth'); // Assuming authentication is needed
