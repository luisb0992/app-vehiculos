<?php

namespace App\Factories;

use App\Enum\StatusRepairOrderEnum;
use App\Enum\StatusVehicleEnum;
use App\Models\Quotation;
use App\Models\RepairOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkshopQuoteFactory
{
  /**
   * Crea una nueva cotización
   *
   * @param array $data
   * @return Quotation
   */
  public static function storeQuota(array $data): mixed
  {
    $trans = DB::transaction(function () use ($data) {
      // verificar si ya la orden tiene una cotización
      $order = RepairOrder::with('quotation')->find($data['repair_order_id']);
      $subs = $order->subcategories()->get();
      $user = auth()->user();

      if ($order->quotation) {
        return false;
      }

      $quotation = Quotation::create([
        'repair_order_id' => $data['repair_order_id'],
        // 'workshop_id' => $data['workshop_id'],
        'user_id' => $user->id,
        'subtotal' => $data['subtotal'],
        'iva' => $data['tax'],
        'total' => $data['total'],
      ]);

      // agregar los costos de las sub categorias
      foreach ($data['subs'] as $subcategory) {
        $sub = $subs->where('id', $subcategory['id'])->first();
        $sub->pivot->cost = $subcategory['cost'];
        $sub->pivot->save();
      }

      // cambiar status de la orden a cotizada
      $order->update(['status' => StatusRepairOrderEnum::QUOTED]);

      return $quotation;
    });

    return $trans;
  }

  /**
   * Aprueba una cotización
   *
   * @param array $data
   * @return bool|null
   */
  public function approveQuotation(array $data): ?bool
  {
    $trans = DB::transaction(function () use ($data) {

      $user = auth()->check() ? auth()->user() : User::find($data['user_id']);

      // actualizar la orden
      $order = RepairOrder::with('quotation')->find($data['order_id']);
      $order->update(['status' => StatusRepairOrderEnum::APPROVED]);

      // guardar la orden de compra
      $order->purchaseOrder()->create([
        'user_id' => $user->id,
        'quotation_id' => $data['quotation_id'],
        'number' => $data['number'],
      ]);

      return true;
    });

    return $trans;
  }

  /**
   * Iniciar una orden de reparación
   *
   * @param array $data
   * @return bool|null
   */
  public function startRepair(array $data): ?bool
  {
    $trans = DB::transaction(function () use ($data) {
      $order = RepairOrder::find($data['order_id']);
      $order->update(['status' => StatusRepairOrderEnum::IN_REPAIR]);

      return true;
    });

    return $trans;
  }

  /**
   * Finalizar una orden de reparación
   *
   * @param array $data
   * @return bool|null
   */
  public function finishRepair(array $data): ?bool
  {
    $trans = DB::transaction(function () use ($data) {
      $order = RepairOrder::find($data['order_id']);
      $order->update(['status' => StatusRepairOrderEnum::REPAIRED]);

      return true;
    });

    return $trans;
  }

  /**
   * Finalizar el caso completamente de orden de reparación
   *
   * @param array $data
   * @return bool|null
   */
  public function finalizedCase(array $data): ?bool
  {
    $trans = DB::transaction(function () use ($data) {

      $orders = $data['orders'];
      $vehicle_id = $orders[0]['vehicle_id'];
      $isAllRepaired = true;

      // verificar si todas las ordenes tienen el status
      // de reparadas
      foreach ($orders as $order) {
        $order = RepairOrder::find($order['id']);
        if ($order->status !== StatusRepairOrderEnum::REPAIRED) {
          $isAllRepaired = false;
        }
      }

      // si todavía hay ordenes sin reparar
      if (!$isAllRepaired) {
        return false;
      }

      // actualizar todos los estados
      foreach ($orders as $order) {
        $order = RepairOrder::find($order['id']);
        $order->update(['status' => StatusRepairOrderEnum::FINALIZED]);
      }

      // actualizar el estado del vehiculo
      $vehicle = Vehicle::find($vehicle_id);
      $vehicle->update(['status' => StatusVehicleEnum::FINALIZED]);

      return true;
    });

    return $trans;
  }
}
