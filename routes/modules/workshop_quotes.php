<?php

use App\Http\Controllers\WorkshopQuoteController;
use Illuminate\Support\Facades\Route;

// rutas con middleware auth y prefix workshop_quotes
Route::middleware('auth')->prefix('workshop_quotes')->group(function () {

  // listado de cotizaciones
  Route::get('index', [WorkshopQuoteController::class, 'index'])
    ->name('workshop_quotes.index')
    ->middleware('is_superadmin_or_supplier');

  // crear una cotización a partir de un vehículo
  Route::get('create-quote/{id}', [WorkshopQuoteController::class, 'createQuote'])
    ->name('workshop_quotes.createQuote')
    ->middleware('is_superadmin_or_supplier');

  // edita una cotización, siempre y cuando no esté aprobada
  Route::get('edit-quote/{id}', [WorkshopQuoteController::class, 'editQuote'])
    ->name('workshop_quotes.editQuote')
    ->middleware('is_superadmin_or_supplier');

  // guardar una cotización
  Route::post('store-quote', [WorkshopQuoteController::class, 'store'])
    ->name('workshop_quotes.storeQuote')
    ->middleware('is_superadmin_or_supplier');

  // actualizar una cotización
  Route::put('update-quote/{quotation}', [WorkshopQuoteController::class, 'update'])
    ->name('workshop_quotes.updateQuote')
    ->middleware('is_superadmin_or_supplier');

  // guardar una factura
  Route::post('store-invoice', [WorkshopQuoteController::class, 'storeInvoice'])
    ->name('workshop_quotes.saveInvoice')
    ->middleware('is_superadmin_or_supplier');

  // descargar la orden de cotización - pdf cotización
  Route::get('download-quote/{id}', [WorkshopQuoteController::class, 'downloadQuote'])
    ->name('workshop_quotes.downloadPDFQuote')
    ->middleware('is_superadmin_or_recorder_or_supplier');

  // aprobar una cotización
  Route::post('approve-quote', [WorkshopQuoteController::class, 'approveQuotation'])
    ->name('workshop_quotes.approveQuotation')
    ->middleware('is_superadmin_or_recorder');

  // iniciar una orden de reparación
  Route::post('start-repair', [WorkshopQuoteController::class, 'startRepair'])
    ->name('workshop_quotes.startRepair')
    ->middleware('is_superadmin_or_supplier');

  // finalizar una orden de reparación
  Route::post('finish-repair', [WorkshopQuoteController::class, 'finishRepair'])
    ->name('workshop_quotes.finishRepair')
    ->middleware('is_superadmin_or_supplier');

  // Finalizar caso
  Route::post('finish-case', [WorkshopQuoteController::class, 'finalizedCase'])
    ->name('workshop_quotes.finalizedCase')
    ->middleware('is_superadmin_or_recorder');
});
