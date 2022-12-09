<?php

namespace App\Enum;

class StatusRepairOrderEnum
{
  // status abierta
  public const OPEN = 1;

  // status en proceso
  public const IN_PROCESS = 2;

  // status cerrada
  public const CLOSED = 3;

  // status cancelada
  public const CANCELED = 4;

  // status rechazada
  public const REJECTED = 5;

  // getValues
  public static function getValues(): array
  {
    return [
      self::OPEN,
      self::IN_PROCESS,
      self::CLOSED,
      self::CANCELED,
      self::REJECTED,
    ];
  }

  // getNames
  public static function getNames(): array
  {
    return [
      self::OPEN => 'Abierta',
      self::IN_PROCESS => 'En proceso',
      self::CLOSED => 'Cerrada',
      self::CANCELED => 'Cancelada',
      self::REJECTED => 'Rechazada',
    ];
  }
}
