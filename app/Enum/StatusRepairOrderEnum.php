<?php

namespace App\Enum;

class StatusRepairOrderEnum
{
  // status abierta
  public const OPEN = 1;

  // status en proceso
  public const IN_REPAIR = 2;

  // status cerrada
  public const CLOSED = 3;

  // status cancelada
  public const CANCELED = 4;

  // status rechazada
  public const REPAIRED = 5;

  // getValues
  public static function getValues(): array
  {
    return [
      self::OPEN,
      self::IN_REPAIR,
      self::REPAIRED,
      self::CLOSED,
      self::CANCELED,
    ];
  }

  // getNames
  public static function getNames(): array
  {
    return [
      self::OPEN => 'Abierta',
      self::IN_REPAIR => 'En reparación',
      self::CLOSED => 'Cerrada',
      self::CANCELED => 'Cancelada',
      self::REPAIRED => 'Reparada',
    ];
  }

  // get array clave valor en ingles
  public static function getArrayKeyValue(): array
  {
    return [
      'open' => self::OPEN,
      'in_repair' => self::IN_REPAIR,
      'closed' => self::CLOSED,
      'canceled' => self::CANCELED,
      'repaired' => self::REPAIRED,
    ];
  }
}
