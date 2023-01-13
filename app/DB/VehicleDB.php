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

  public function getVehiclesReportsFilter($brand,$model,$dates,$nro_chasis){
    //dd($brand,$model,$dates,$nro_chasis);
    $vehicles = $this->vehicle
                ->with(['repairOrders', 'color', 'brand', 'model', 'gallery'])
                ->withCount('repairOrders')
                ->brand($brand)
                ->model($model)
                ->chassis($nro_chasis)
                ->dateBetween($dates);

    return $vehicles->get();
  }
}
