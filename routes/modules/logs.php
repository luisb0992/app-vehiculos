<?php

use App\Http\Controllers\ActivityLogController;
use Illuminate\Support\Facades\Route;

Route::name('logs.')
  ->middleware(['auth', 'is_superadmin'])
  ->prefix('logs')
  ->group(function () {
    Route::get('log-activity', [ActivityLogController::class, 'index'])
      ->name('index');

    //export to PDF
    Route::get('log-activity/pdf', [ActivityLogController::class, 'downloadPDF'])->name('pdf');
    //export to excel
    Route::get('log-activity/excel', [ActivityLogController::class, 'downloadEXCEL'])->name('excel');
  });
