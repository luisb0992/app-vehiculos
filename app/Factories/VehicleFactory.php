<?php

namespace App\Factories;

use App\Models\Vehicle;

class VehicleFactory
{
  /**
   * @param array<string, mixed> $data
   * @return Vehicle
   */
  public function createVehicle(array $data): Vehicle
  {
    return Vehicle::create([
      'chassis_number' => $data['chassis_number'],
      'brand_id' => $data['brand_id'],
      'model_id' => $data['model_id'],
      'color_id' => $data['color_id'],
      'year' => $data['year'],
      'mileage' => $data['mileage'],
      'price' => $data['price'],
      'description' => $data['description'],
      'observation' => $data['observation'],
      'status' => $data['status'],
    ]);
  }
}
