<?php

namespace App\Factories;

use App\Enum\StatusRepairOrderEnum;
use App\Enum\StatusVehicleEnum;
use App\Models\RepairOrder;
use App\Models\RepairSubCategory;
use App\Models\Vehicle;
use App\Utils\AppStorage;
use App\Utils\IntervationImage;
use Illuminate\Support\Facades\DB;

class VehicleFactory
{
  use AppStorage;
  use IntervationImage;

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
      'user_id' => auth()->user()->id,
      'status' => StatusVehicleEnum::ADD,
    ]);
  }

  /**
   * Guardar galeria de imagenes y optimizarlas
   *
   * @param Vehicle $vehicle
   * @param array $files
   */
  public function saveGallery($vehicle, $files): mixed
  {
    $ts = DB::transaction(function () use ($vehicle, $files) {
      // path
      $originalSP = config('storage.vehicle.original_sp');
      $resizeSP = config('storage.vehicle.resize_sp');

      // guardar las imagenes originales
      foreach ($files as $file) {

        // verificar si es una archivo valido de laravel
        // de lo contrario, saltar al siguiente archivo
        if (!$file->isValid()) {
          continue;
        }

        // save original image
        $name = $this->generateName('image_');
        $randomFileName = $this->saveFile($file, $name, $originalSP);

        // si se guardo con éxito, resize
        if ($randomFileName) {
          // optimizar la imagen
          $image = $this->initImage($file->getRealPath());
          $image = $this->resizeImage($image);
          $encode = $this->encodeImage($image);

          // guardar la imagen resize en el storage
          $resizeFilename = $this->generateName('image_resize_') . '.webp';
          $fullPath = $resizeSP . $resizeFilename;
          $saveResize = $this->saveSimpleFile($encode, $fullPath);

          // guardar la imagen en la galeria BD
          if ($saveResize) {
            $vehicle->gallery()->create([
              'name' => $file->getClientOriginalName(),
              'path' => $resizeFilename,
            ]);
          }
        }
      }
    });

    return $ts;
  }

  /**
   * Guardar nuevas ordenes de reparación
   *
   * @param array $data
   */
  public function storeRepair(array $data): mixed
  {
    $ts = DB::transaction(function () use ($data) {

      // user
      $user = auth()->user();

      // cambia el estado del vehículo a request_send
      $vehicle = Vehicle::find($data['vehicle_id']);
      $vehicle->status = StatusVehicleEnum::REQUEST_SEND;
      $vehicle->save();

      // iterar ordenes de reparación
      foreach ($data['orders'] as $order) {

        // guardar orden de reparación
        $newOrder = RepairOrder::create([
          'vehicle_id' => $data['vehicle_id'],
          'user_id' => $user->id,
          'workshop_id' => $order['workshop_id'],
          'send_date' => $order['send_date'],
          'status' => StatusRepairOrderEnum::OPEN,
        ]);

        // guardar categorias y subcategorias
        foreach ($order['subs'] as $sub) {

          // obtener categoría
          $RepairSub = RepairSubCategory::find($sub['sub_id']);

          // guardar categoría
          $newOrder->categories()->attach($RepairSub->repair_category_id, [
            'repair_sub_category_id' => $sub['sub_id'],
            'warranty' => isset($sub['warranty']) ? $sub['warranty'] : false,
            'dock' => isset($sub['dock']) ? $sub['dock'] : false,
          ]);
        }
      }

      return true;
    });

    return $ts;
  }
}
