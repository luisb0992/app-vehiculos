<?php

namespace App\DB;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Collection;
use App\Enum\StatusRepairOrderEnum;

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
    $user = auth()->user();

    $data =  $this->vehicle
      ->with(['repairOrders.quotation', 'color', 'brand', 'model', 'gallery', 'repairOrders.purchaseOrder'])
      ->withCount('repairOrders')
      ->orderByDesc('created_at');

    // si es un supera admin, devolver todos los vehículos
    if ($user->isSuperAdmin()) {
      return $data->get();
    }

    return $data->where('user_id', $user->id)->get();
  }

  public function getVehiclesReportsFilter($brand = null, $model = null, $dates = null, $nro_chasis = null, $user_id = null)
  {
    $vehicles = $this->vehicle
      ->with(['repairOrdersWithStatus.subcategories', 'brand', 'model', 'gallery', 'user', 'repairOrdersWithoutListed.subcategories'])
      ->withCount('repairOrders')
      ->brand($brand)
      ->model($model)
      ->user($user_id)
      ->chassis($nro_chasis)
      ->dateBetween($dates);

    //dd($vehicles->get());

    $result = $vehicles->get()->map(function ($vehicle) {
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
        'status_last_order' =>  StatusRepairOrderEnum::getValueFromKey($vehicle->status_last_order),
        'user' => $vehicle->user->name . ' ' . $vehicle->user->last_name,
        'photos' => $vehicle->gallery,
        'year'  => $vehicle->year ?? '---',
        'mileage' => $vehicle->mileage ?? '---',
        'price' => $vehicle->price ?? '---',
        'description' => $vehicle->description ?? '---',
        'observation' => $vehicle->observation ?? '---',
        'repair_orders' => $vehicle->repairOrders->map(function ($order) {
          return [
            'id' => $order->id,
            'workshop' => $order->workshop->name,
            'date' => $order->send_date,
            'status' => StatusRepairOrderEnum::getValueFromKey($order->status),
            'total' => $order->status == 2 ? 0 : $order->quotation->total ?? 0,
            'subtotal' => $order->status == 2 ? 0 : $order->quotation->subtotal ?? 0,
            'iva' => $order->status == 2 ? 0 : $order->quotation->iva ?? 0,
          ];
        }),
      ];
    });


    return $result;
  }
}
