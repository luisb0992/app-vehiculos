<?php

/**
 * gestión de los estados de los vehículos
 *
 * @author luisandev
 */

namespace App\Enum;

final class StatusVehicleEnum
{
  public const AVAILABLE = 1;
  public const PENDING = 2;
  public const MAINTENANCE = 3;
  public const REPAIR = 4;
  public const DELETED = 5;

  public static function getValues(): array
  {
    return [
      self::AVAILABLE,
      self::PENDING,
      self::MAINTENANCE,
      self::REPAIR,
      self::DELETED,
    ];
  }

  public static function getLabels($status = null): array
  {
    $labels = [
      self::AVAILABLE => 'Disponible',
      self::PENDING => 'Pendiente',
      self::MAINTENANCE => 'En mantenimiento',
      self::REPAIR => 'Reparado',
      self::DELETED => 'Eliminado',
    ];

    if ($status) {
      return $labels[$status];
    }

    return $labels;
  }
}
