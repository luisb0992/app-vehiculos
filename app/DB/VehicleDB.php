<?php

namespace App\DB;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Collection;
use Termwind\Components\Dd;

class VehicleDB
{

  // constructor
  public function __construct(
    private Vehicle $vehicle,
  ) {
  }

  /**
   * @param int $id
   * @return Vehicle
   */
  public function getVehicleById(int $id): ?Vehicle
  {
    return $this->vehicle->find($id);
  }

  /**
   * @param int $id
   * @return Vehicle
   */
  public function getVehicleByIdWithRelation(int $id): ?Vehicle
  {
    return $this->vehicle->with(['brand', 'color', 'model', 'gallery'])->find($id);
  }

  /**
   * Comprueba Si el vehículo tiene ordenes de reparación
   */
  public function checkVehicleHasRepairOrders(int $id): null|bool
  {
    return $this->getVehicleById($id)?->repairOrders()?->exists();
  }

  /**
   * Devolver los vehículos que el usuario a agregado
   * junto con las ordenes de reparación
   *
   * @return Collection
   */
  public function getVehiclesByUser(): Collection
  {
    return $this->vehicle
      ->with(['repairOrders.quotation', 'color', 'brand', 'model', 'gallery', 'repairOrders.purchaseOrder'])
      ->withCount('repairOrders')
      ->where('user_id', auth()->user()->id)
      ->orderByDesc('created_at')
      ->get();
  }

  public function getVehiclesReportsFilter($brand = null,$model = null,$dates = null,$nro_chasis = null,$user_id = null){
    $vehicles = $this->vehicle
                ->with(['repairOrders.subcategories' ,'brand', 'model', 'gallery','user'])
                ->withCount('repairOrders')
                ->brand($brand)
                ->model($model)
                ->user($user_id)
                ->chassis($nro_chasis)
                ->dateBetween($dates);

    $result = $vehicles->get()->map(function($vehicle){
        return [
            'chassis_number' => $vehicle->chassis_number,
            'brand' => $vehicle->brand->name,
            'model' => $vehicle->model->name,
            'color' => $vehicle->color->name,
            'status' => $vehicle->status,
            'dock'  => $vehicle->dock,
            'warranty' => $vehicle->warranty,
            'total' => $vehicle->dock + $vehicle->warranty,
            'status_word' => $vehicle->status_word,
            'user' => $vehicle->user->name.' '.$vehicle->user->last_name,
            'photos' => $vehicle->gallery,
            'year'  => $vehicle->year ?? '---',
            'mileage' => $vehicle->mileage ?? '---',
            'price' => $vehicle->price ?? '---',
            'description' => $vehicle->description ?? '---',
            'observation' => $vehicle->observation ?? '---',

        ];
    });


    return $result;
  }
}
