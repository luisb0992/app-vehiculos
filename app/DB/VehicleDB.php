<?php

namespace App\DB;

use App\Models\Vehicle;

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
}
