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

  public function getAllModelsOrderASC(): Collection
  {
    return ModelVehicle::with('brand')->orderBy('id', 'DESC')->get(['id', 'name', 'brand_id']);
  }

  public function getModelsByBrand($brand): Collection
  {
    return ModelVehicle::where('brand_id',$brand)->get();
  }

  public function findModelWithId(int $id): ModelVehicle
   {
     return ModelVehicle::findOrFail($id);
   }

   public function updateModel(array $data, $model): bool
   {
     $model->name = $data['name'];
     $model->brand_id = $data['brand_id'];

     return $model->save();
   }

   public function getModelsWithBrand(){

    return ModelVehicle::with('brand')->get();

  }
}
