<?php

namespace App\Traits;

use App\Enum\StatusVehicleEnum;
use Illuminate\Database\Eloquent\Builder;

trait ScopeVehicle
{

  public function scopeWhereStatusOrders($query)
  {
    $query->repairOrders->whereIn('status', [3, 5, 6, 7]);
  }

  public function scopeStatus($query, $status)
  {
    if ($status) {
      return $query->whereHas('repairOrders', function (Builder $query) use ($status) {
        $query->where('status', $status);
      });
    }
  }

  public function scopeUser($query, $user)
  {
    if ($user) {
      return $query->where('user_id', $user);
    }
  }

  public function scopeModel($query, $model)
  {
    if ($model) {
      return $query->where('model_id', $model);
    }
  }

  public function scopeBrand($query, $brand)
  {
    if ($brand) {
      return $query->where('brand_id', $brand);
    }
  }

  public function scopeDateBetween($query, $date)
  {
    if (!empty($date)) {
      if (!is_null($date['start']) && !is_null($date['end'])) {
        return $query->whereBetween('created_at', [$date['start'], $date['end']]);
      }
    }
  }

  public function scopeChassis($query, $nro_chasis)
  {
    if ($nro_chasis) {
      return $query->where('chassis_number', 'LIKE', "{$nro_chasis}%");
    }
  }

  /**
   * Devuelve los vehículos filtrados por status
   * finalizado,
   * cancelado
   * orden rechazada
   *
   * vehiculo finalizado
   *
   * @param Builder $query
   */
  public function scopeStatusFinished($query): Builder
  {
    return $query->where([
      ['status', '!=', StatusVehicleEnum::FINALIZED],
      ['status', '!=', StatusVehicleEnum::CANCELLED],
      ['status', '!=', StatusVehicleEnum::REJECTED_QUOTE],
    ]);
  }

  /**
   * Scope date from - to filter
   *
   * @param Builder $query
   */
  public function scopeDateFromTo($query, $dateFrom, $dateTo): Builder
  {
    return $query->whereHas('repairOrders', function ($order) use ($dateFrom, $dateTo) {
      $order->whereBetween('created_at', [$dateFrom, $dateTo]);
    });
  }
}
