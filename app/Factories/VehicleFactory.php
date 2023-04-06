<?php

namespace App\Factories;

use App\Enum\StatusRepairOrderEnum;
use App\Enum\StatusVehicleEnum;
use App\Mail\NotifySupplierUserEmail;
use App\Models\Brand;
use App\Models\Color;
use App\Models\ModelVehicle;
use App\Models\RepairOrder;
use App\Models\RepairSubCategory;
use App\Models\User;
use App\Models\Vehicle;
use App\Utils\AppStorage;
use App\Utils\IntervationImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class VehicleFactory
{
  use AppStorage;
  use IntervationImage;

  /**
   * @param array<string, mixed> $data
   * @return Vehicle|null
   */
  public function createVehicle(array $data): ?Vehicle
  {

    // buscar primero si existe el vehiculo
    $vehicle = Vehicle::where('chassis_number', $data['chassis_number'])->first();

    // si existe, retornar el vehiculo
    if ($vehicle) {
      return null;
    }

    // verificar si existen
    $brand = Brand::where('name', $data['brand_id'])->first();
    $model = ModelVehicle::where('name', $data['model_id'])->first();
    $color = Color::where('name', $data['color_id'])->first();

    if (!$brand) {
      $brand = Brand::create(['name' => $data['brand_id']]);
    }

    if (!$model) {
      $model = ModelVehicle::create(['name' => $data['model_id'], 'brand_id' => $brand->id]);
    }

    if (!$color) {
      $color = Color::create(['name' => $data['color_id']]);
    }

    $brandID = $brand->id;
    $modelID = $model->id;
    $colorID = $color->id;

    return Vehicle::create([
      'chassis_number' => strtoupper($data['chassis_number']),
      'brand_id' => $brandID,
      'model_id' => $modelID,
      'color_id' => $colorID,
      'company' => $data['company'],
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

        // notificar a los usuarios del taller
        $this->notifyUsersNewOrderHasBeenCreated($order['workshop_id'], $newOrder);
      }

      // cambia el estado del vehículo a solicitud de reparación enviada
      $vehicle = Vehicle::find($data['vehicle_id']);
      $vehicle->update(['status' => StatusVehicleEnum::REQUESTED_REPAIR]);

      return true;
    });

    return $ts;
  }

  /**
   * Cargar los usuarios por taller
   * y notificar nueva orden de reparación
   *
   * @param int $workshopID
   * @param RepairOrder $order
   * @return void
   */
  public function notifyUsersNewOrderHasBeenCreated(int $workshopID, RepairOrder $order): void
  {
    // cargar todos los usuarios de un taller
    $workshopUsers = User::byWorkshop($workshopID)->get();

    // iterar
    // tomar el email y notificar via email
    $workshopUsers->each(function ($userF) use ($order) {
      $email = new NotifySupplierUserEmail($order);
      Mail::to($userF->email)->send($email);
    });
  }
}
