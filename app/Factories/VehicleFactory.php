<?php

namespace App\Factories;

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
      'year' => $data['year'],
      'mileage' => $data['mileage'],
      'price' => $data['price'],
      'description' => $data['description'],
      'observation' => $data['observation'],
      'status' => $data['status'],
    ]);
  }

  /**
   * Guardar galeria de imagenes y optimizarlas
   *
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
}
