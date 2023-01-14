<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// clear all cache
Route::get('/optimizeclear', function () {
  Artisan::call('optimize:clear');
  return 'Cache cleared';
});

// migrate
Route::get('/migrateall', function () {
  Artisan::call('migrate');
  return 'Migrated';
});

// migrate --seed
Route::get('/migrate-seed', function () {
  Artisan::call('migrate --seed');
  return 'Migrated with seed';
});

// storage link
Route::get('/storagelink', function () { //ejecutar este primero
  Artisan::call('storage:link');
  return "storage link generado";
});

// storage link
Route::get('/symlink', function () { //ejecutar de segundo
  $targetFolder = storage_path('app/public');
  $linkFolder = $_SERVER['DOCUMENT_ROOT'] . '/storage';
  symlink($targetFolder, $linkFolder);
  return "symlink generado";
});