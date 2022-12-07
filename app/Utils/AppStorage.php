<?php

/**
 * gestionar el sistema de archivos de la app
 *
 * @luisandev
 */

namespace App\Utils;

use Illuminate\Support\Facades\Storage;

trait AppStorage
{

  /**
   * Nombre por defecto para un archivo
   *
   * @return string
   */
  public function generateName(string $string = 'file_'): string
  {
    return $string . date('dmYhis') . rand(0, 1000);
  }

  /**
   * Guarda un archivo en el sistema de archivos de la app
   *
   * @param File $file      Archivo a almacenar
   * @param String $name    nombre opcional para el archivo
   * @return string         El nombre dado al archivo
   */
  public function saveFile($file, $name = null, $path): ?string
  {
    $name = $name ?? $file->getClientOriginalName();
    $extension = $file->extension();
    $finalName = pathinfo($name, PATHINFO_FILENAME) . '.' . $extension;
    $save = Storage::disk(env('FILESYSTEM_DRIVER'))->putFileAs($path, $file, $finalName);

    return $save ? $finalName : null;
  }

  /**
   * Guarda la imagen de forma tradicional
   * sin optimizarla, usando el método put
   *
   * @param File $file
   * @param string $fullPath
   * @return boolean          true si fue guardado, false caso contrario
   */
  public function saveSimpleFile($file, $fullPath): bool
  {
    return Storage::put($fullPath, $file);
  }

  /**
   * actualiza el archivo en el sistema de archivos de la app
   *
   * @param String $oldFilename   nombre del anterior archivo
   * @param File $file            Nuevo Archivo a almacenar
   * @param String $path          ruta donde se almacena el nuevo archivo
   * @param String $name          El nombre para el nuevo archivo
   * @return String               El nombre dado al archivo
   */
  public function updateFile($oldFilename, $file, $path, $name = null): string
  {
    // eliminar el antiguo archivo
    $this->deleteFile($oldFilename, $path);

    // actualizar
    return $this->saveFile($file, $name, $path);
  }

  /**
   * Elimina un archivo del sistema de archivos
   *
   * @param String $filename      nombre del archivo
   * @return boolean              true si fue eliminado, false caso contrario
   */
  public function deleteFile($filename, $path): bool
  {
    $fullPath = $path . $filename;
    return Storage::disk(env('FILESYSTEM_DRIVER'))->delete($fullPath);
  }

  /**
   * Devuelve el archivo del sistema de archivos
   *
   * @param String $filename      nombre del archivo
   * @param String $path          ruta donde se almacena el archivo
   * @return String|null          contenido del archivo
   */
  public function getFile($path, $filename): ?string
  {
    $fullPath = $path . $filename;
    return Storage::disk(env('FILESYSTEM_DRIVER'))->get($fullPath);
  }
}
