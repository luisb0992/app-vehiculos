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
    ->name('workshop_quotes.create-quote');

  // guardar una cotización
  Route::post('store', [WorkshopQuoteController::class, 'store'])
    ->name('workshop_quotes.store');
});
