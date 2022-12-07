<?php

namespace App\Utils;

use Image as InterventionImage;
use Intervention\Image\Image;

trait IntervationImage
{

  /**
   * Default width
   *
   * @return integer
   */
  public function defaultWidth(): int
  {
    return 600;
  }

  /**
   * default height
   *
   * @return integer
   */
  public function defaultHeight(): int
  {
    return 600;
  }

  /**
   * Devuelve el objeto imagen de Intervention
   *
   * @param string $path    path de la imagen
   */
  public function initImage(string $path): ?Image
  {
    return InterventionImage::make($path);
  }

  /**
   * Devuelve el objeto resize de Intervention
   *
   * @param Image $image            objeto imagen de Intervention
   * @param integer|null $width     ancho
   * @param integer|null $height    alto
   * @return Image|null             objeto resize de Intervention
   */
  public function resizeImage($image, int $width = null, int $height = null): ?Image
  {
    $width = $width ?? $this->defaultWidth();
    $height = $height ?? $this->defaultHeight();
    return $image->resize($width, $height, function ($constraint) {
      $constraint->aspectRatio();
      $constraint->upsize();
    });
  }

  /**
   * Devuelve la imagen en el formato especificado
   *
   * @param Image $image        objeto imagen de Intervention
   * @param string $format      formato de la imagen
   * @param integer $quality    calidad de la imagen
   * @return Image|null         objeto imagen de Intervention
   */
  public function encodeImage($image, string $format = 'webp', int $quality = 80): ?Image
  {
    return $image->encode($format, $quality);
  }
}
