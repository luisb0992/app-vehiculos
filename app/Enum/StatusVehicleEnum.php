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
  public const IN_REPAIR = 4;
  public const REPAIRED = 5;
  public const ADD = 6;
  public const REQUEST_SEND = 7;

  public static function getValues(): array
  {
    return [
      self::AVAILABLE,
      self::PENDING,
      self::MAINTENANCE,
      self::IN_REPAIR,
      self::REPAIRED,
      self::ADD,
      self::REQUEST_SEND,
    ];
  }

  public static function getLabels($status = null): array
  {
    $labels = [
      self::AVAILABLE => 'Disponible',
      self::PENDING => 'Pendiente',
      self::MAINTENANCE => 'En mantenimiento',
      self::IN_REPAIR => 'En Reparación',
      self::REPAIRED => 'Reparado',
      self::ADD => 'Agregado',
      self::REQUEST_SEND => 'Solicitud enviada',
    ];

    if ($status) {
      return $labels[$status];
    }

    return $labels;
  }

  // array clave valor
  public static function getArrayKeyValue(): array
  {
    return [
      'available' => self::AVAILABLE,
      'pending' => self::PENDING,
      'maintenance' => self::MAINTENANCE,
      'in_repair' => self::IN_REPAIR,
      'repaired' => self::REPAIRED,
      'add' => self::ADD,
      'request_send' => self::REQUEST_SEND,
    ];
  }
}
