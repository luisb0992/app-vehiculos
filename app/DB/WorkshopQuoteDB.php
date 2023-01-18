<?php

namespace App\DB;

use App\Models\Quotation;
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
  public function getAllByWorkshop(): Collection
  {
    $user = auth()->user();
    return RepairOrder::where('workshop_id', $user->workshop_id)
      ->with([
        'vehicle.brand', 'vehicle.model', 'vehicle.color', 'vehicle.gallery', 'quotation'
      ])
      ->orderByDesc('created_at')
      ->get();
  }

  /**
   * Devuelve la orden de cotización por id
   *
   * @param int $id
   * @return RepairOrder
   */
  public function getOrderById(int $id): RepairOrder
  {
    return RepairOrder::with([
      'vehicle.brand', 'vehicle.model', 'vehicle.color', 'vehicle.gallery',
      'workshop', 'categories', 'subcategories', 'quotation'
    ])->find($id);
  }

  /**
   * Devuelve la cotización de la orden
   *
   * @param int $id
   * @return RepairOrder
   */
  public function getQuotationByID(int $id): ?Quotation
  {
    return Quotation::with([
      'repairOrder.vehicle.brand', 'repairOrder.vehicle.model', 'repairOrder.vehicle.color', 'repairOrder.vehicle.gallery',
      'repairOrder.workshop', 'repairOrder.categories', 'repairOrder.subcategories'
    ])->find($id);
  }
}
