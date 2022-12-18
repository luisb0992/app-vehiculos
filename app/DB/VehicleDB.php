<?php

namespace App\DB;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Collection;

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
  public function getVehicleById(int $id): Vehicle
  {
    return $this->vehicle->find($id);
  }

  /**
   * @param int $id
   * @return Vehicle
   */
  public function getVehicleByIdWithRelation(int $id): Vehicle
  {
    return $this->vehicle->with(['brand', 'color', 'model', 'gallery'])->find($id);
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
      ->with(['repairOrders', 'color', 'brand', 'model', 'gallery'])
      ->where('user_id', auth()->user()->id)
      ->orderByDesc('created_at')
      ->get();
  }
}
