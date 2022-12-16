<?php

namespace App\DB;

use App\Models\RepairOrder;
use Illuminate\Database\Eloquent\Collection;

class WorkshopQuoteDB
{
  /**
   * Devuelve todas las ordenes de cotización por taller
   * el taller se toma del usuario logueado
   *
   * @return Collection
   */
  public static function getAllByWorkshop(): Collection
  {
    $user = auth()->user();
    return RepairOrder::where('workshop_id', $user->workshop_id)
      ->with(['vehicle.brand', 'vehicle.model', 'vehicle.color', 'vehicle.gallery'])
      ->get();
  }
}
