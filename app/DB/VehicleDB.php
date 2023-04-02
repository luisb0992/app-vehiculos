<?php

namespace App\DB;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Collection;
use App\Enum\StatusRepairOrderEnum;
use App\Enum\StatusVehicleEnum;
use Illuminate\Database\Eloquent\Builder;

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
   * Get data vehicles
   */
  public function getVehiclesWithRelations(): Builder
  {
    return $this->vehicle
      ->with([
        'color', 'brand', 'model', 'gallery',
        'repairOrders.purchaseOrder',
        'repairOrders.workshop',
        'repairOrders.quotation'
      ])
      ->withCount('repairOrders')
      ->orderByDesc('created_at');
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
    $request = request()->all();
    $existsStatus = isset($request['status']);
    $existsDateFrom = isset($request['date_from']);
    $existsDateTo = isset($request['date_to']);
    // $data = $this->getVehiclesWithRelations()->statusFinished();
    $data = $this->getVehiclesWithRelations();

    // si hay que filtrar por status
    if ($existsStatus) {
      $status = intval($request['status']);
      $data = $this->getVehiclesByStatus($status, $data);
    }

    // si hay que filtrar por fechas
    if ($existsDateFrom || $existsDateTo) {
      $data = $data->dateFromTo($request['date_from'], $request['date_to']);
    }

    // si hay request de búsqueda, return
    if ($existsStatus || $existsDateFrom || $existsDateTo) {
      return $data->get();
    }

    // si es un super admin, devolver todos los vehículos
    if ($user->isSuperAdmin()) {
      return $data->statusFinished()->get();
    }

    // si no devolver los vehículos del usuario
    return $data->statusFinished()->where('user_id', $user->id)->get();
  }

  /**
   * Filtrar los vehículos según los status recibidos
   *
   * @param int $status         status
   * @param Builder $data       datos
   * @return Builder
   */
  public function getVehiclesByStatus(int $status, $data): Builder
  {
    // con status cotizado
    if ($status === StatusVehicleEnum::QUOTED) {
      $data = $data->status(StatusRepairOrderEnum::QUOTED);
    }

    // con status en reparación
    if ($status === StatusVehicleEnum::IN_REPAIR) {
      $data = $data->status(StatusRepairOrderEnum::IN_REPAIR);
    }

    // con status finalizado
    if ($status === StatusVehicleEnum::FINALIZED) {
      $data = $data->status(StatusRepairOrderEnum::FINALIZED);
    }

    return $data;
  }

  /**
   * Filtrar vehiculos según fechas desde - hasta recibidas
   *
   * @param string $dateFrom    fecha desde
   * @param string $dateTo      fecha hasta
   * @return Collection
   */
  public function getVehiclesByDate(string $dateFrom, string $dateTo): Collection
  {
    return $this->getVehiclesWithRelations()
      ->whereHas('repairOrders', function ($query) use ($dateFrom, $dateTo) {
        $query->whereBetween('created_at', [$dateFrom, $dateTo]);
      })
      ->get();
  }

  public function getVehiclesReportsFilter($brand = null, $model = null, $dates = null, $nro_chasis = null, $user_id = null, $status = null)
  {
    $vehicles = $this->vehicle
      ->with(['repairOrdersWithStatus.subcategories', 'brand', 'model', 'gallery', 'user', 'repairOrdersWithStatus.quotation'])
      ->withCount('repairOrders')
      ->brand($brand)
      ->status($status)
      ->model($model)
      ->user($user_id)
      ->chassis($nro_chasis)
      ->dateBetween($dates);

    $result = $vehicles->get()->map(function ($vehicle) {
      return [
        'id' => $vehicle->id,
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
            'total' => $order->status == 2 ||  $order->status == 4 ? 0 : $order->quotation->total ?? 0,
            'subtotal' => $order->status == 2 ||  $order->status == 4 ? 0 : $order->quotation->subtotal ?? 0,
            'iva' => $order->status == 2 ||  $order->status == 4 ? 0 : $order->quotation->iva ?? 0,
            'invoice_number' => $order->quotation->invoice_number ?? null,
            'invoice_path' => $order->quotation->invoice_path ?? null,
          ];
        }),
      ];
    });


    return $result;
  }

  public function getVehicleReportById($id)
  {
    $vehicle = $this->vehicle
      ->with(['repairOrdersWithStatus.subcategories', 'brand', 'model', 'gallery', 'user'])
      ->withCount('repairOrders')
      ->findOrfail($id);

    return $vehicle;
  }
}
