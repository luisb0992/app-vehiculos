<?php

use App\Http\Controllers\WorkshopQuoteController;
use Illuminate\Support\Facades\Route;

// rutas con middleware auth y prefix workshop_quotes
Route::middleware('auth')->prefix('workshop_quotes')->group(function () {

  // listado de cotizaciones
  Route::get('index', [WorkshopQuoteController::class, 'index'])
    ->name('workshop_quotes.index');

  // crear una cotización a partir de un vehículo
  Route::get('create-quote/{id}', [WorkshopQuoteController::class, 'createQuote'])
    ->name('workshop_quotes.createQuote');

  // guardar una cotización
  Route::post('store-quote', [WorkshopQuoteController::class, 'store'])
    ->name('workshop_quotes.storeQuote');

  // descargar la orden de cotización
  Route::get('download-quote/{id}', [WorkshopQuoteController::class, 'downloadQuote'])
    ->name('workshop_quotes.downloadPDFQuote');

  // aprobar una cotización
  Route::post('approve-quote', [WorkshopQuoteController::class, 'approveQuotation'])
    ->name('workshop_quotes.approveQuotation');

  // iniciar una orden de reparación
  Route::post('start-repair', [WorkshopQuoteController::class, 'startRepair'])
    ->name('workshop_quotes.startRepair');

  // iniciar una orden de reparación
  Route::post('finish-repair', [WorkshopQuoteController::class, 'finishRepair'])
    ->name('workshop_quotes.finishRepair');

  // Finalizar caso
  Route::post('finish-case', [WorkshopQuoteController::class, 'finalizedCase'])
    ->name('workshop_quotes.finalizedCase');
});
