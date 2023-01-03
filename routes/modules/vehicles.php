<?php

use App\Http\Controllers\Vehicle\ReportsVehicleController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

// rutas con middleware auth y prefix vehicles
Route::middleware('auth')->prefix('vehicles')->group(function () {

  // crear vehículo
  Route::get('index', [VehicleController::class, 'index'])
    ->name('vehicle.index');

  Route::get('create', [VehicleController::class, 'create'])
    ->name('vehicle.create');

  // guardar vehículo
  Route::post('store', [VehicleController::class, 'store'])
    ->name('vehicle.store');

  // solicitar reparación
  Route::get('repair/{id}', [VehicleController::class, 'repair'])
    ->name('vehicle.repair');

  // guardar datos de reparación
  Route::post('store-repair', [VehicleController::class, 'storeRepair'])
    ->name('vehicle.store.repair');

  // reports view
  Route::get('reports/vehicle', [ReportsVehicleController::class, 'index'])
    ->name('vehicle.reports');

// request reports
  Route::post('reports/vehicle', [ReportsVehicleController::class, 'queryVehicle'])
  ->name('vehicle.reports.post');

  //pdf reports vehicle
  Route::get('reports/pdf', [ReportsVehicleController::class, 'downloadPDF'])->name('vehicle.reports.pdf');

  //excel reports vehicle
  Route::get('reports/excel', [ReportsVehicleController::class, 'downloadEXCEL'])->name('vehicle.reports.excel');

});
