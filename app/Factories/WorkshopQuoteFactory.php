<?php

namespace App\Factories;

use App\Enum\StatusRepairOrderEnum;
use App\Models\Quotation;
use App\Models\RepairOrder;
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

      // cambiar status de la orden
      $order->status = StatusRepairOrderEnum::SEND;
      $order->save();

      return $quotation;
    });

    return $trans;
  }
}
