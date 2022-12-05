<?php

namespace App\Factories;

use App\Models\ModelVehicle;
use Illuminate\Database\Eloquent\Collection;

class ModelVehicleFactory
{
  // ordenar por nombre
  public function getAllModels(): Collection
  {
    return ModelVehicle::orderBy('name')->get(['id', 'name', 'brand_id']);
  }
}
