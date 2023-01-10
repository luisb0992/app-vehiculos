<?php

/**
 * gestión de los estados de los vehículos
 *
 * @author luisandev
 */

namespace App\Enum;

final class StatusVehicleEnum
{

  // vehiculo agregado
  public const ADD = 1;

  // Solicitud de reparación enviada
  public const REQUESTED_REPAIR = 2;

  // cotización realizada o cotizado
  public const QUOTED = 3;

  // cotización aprobada
  public const APPROVED_QUOTE = 4;

  // cotización rechazada
  public const REJECTED_QUOTE = 5;

  // en reparación por el taller
  public const IN_REPAIR = 6;

  // reparado por el taller
  public const REPAIRED = 7;

  // caso finalizado, el vehiculo fue reparado y fue confirmado por el usuario
  public const FINALIZED = 8;

  // si ocurrió algún cambio en el proceso, se cancela el caso
  public const CANCELLED = 9;

  public static function getValues(): array
  {
    return [
      self::ADD,
      self::REQUESTED_REPAIR,
      self::QUOTED,
      self::APPROVED_QUOTE,
      self::REJECTED_QUOTE,
      self::IN_REPAIR,
      self::REPAIRED,
      self::FINALIZED,
      self::CANCELLED,
    ];
  }

  public static function getLabels($status = null): array
  {
    $labels = [
      self::ADD => 'Agregado',
      self::REQUESTED_REPAIR => 'Solicitud de reparación enviada',
      self::QUOTED => 'Cotización realizada',
      self::APPROVED_QUOTE => 'Cotización aprobada',
      self::REJECTED_QUOTE => 'Cotización rechazada',
      self::IN_REPAIR => 'En reparación',
      self::REPAIRED => 'Reparado',
      self::FINALIZED => 'Finalizado',
      self::CANCELLED => 'Cancelado',
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
      'add' => self::ADD,
      'requested_repair' => self::REQUESTED_REPAIR,
      'quoted' => self::QUOTED,
      'approved_quote' => self::APPROVED_QUOTE,
      'rejected_quote' => self::REJECTED_QUOTE,
      'in_repair' => self::IN_REPAIR,
      'repaired' => self::REPAIRED,
      'finalized' => self::FINALIZED,
      'cancelled' => self::CANCELLED,
    ];
  }
}
