<?php

namespace App\Enum;

class StatusRepairOrderEnum
{
  // orden abierta/pendiente por cotizar
  public const OPEN = 1;

  // orden/vehiculo en reparación
  public const QUOTED = 2;

  // orden/vehiculo en reparación
  public const IN_REPAIR = 3;

  // orden cancelada
  public const CANCELED = 4;

  // orden finalizada, cuando el vehiculo fue reparado
  public const REPAIRED = 5;

  // orden finalizada, cuando todo salio bien o mal
  public const FINALIZED = 6;

  public const APPROVED = 6;

  // getValues
  public static function getValues(): array
  {
    return [
      self::OPEN,
      self::QUOTED,
      self::IN_REPAIR,
      self::CANCELED,
      self::REPAIRED,
      self::FINALIZED,
      self::APPROVED,
    ];
  }

  // getNames
  public static function getNames(): array
  {
    return [
      self::OPEN => 'Abierta',
      self::QUOTED => 'Cotizada',
      self::IN_REPAIR => 'En reparación',
      self::CANCELED => 'Cancelada',
      self::REPAIRED => 'Reparada',
      self::FINALIZED => 'Finalizada',
      self::APPROVED => 'Aprobada',
    ];
  }

  // get array clave valor en ingles
  public static function getArrayKeyValue(): array
  {
    return [
      'open' => self::OPEN,
      'quoted' => self::QUOTED,
      'in_repair' => self::IN_REPAIR,
      'cancelLed' => self::CANCELED,
      'repaired' => self::REPAIRED,
      'finalized' => self::FINALIZED,
      'approved' => self::APPROVED,
    ];
  }
}
