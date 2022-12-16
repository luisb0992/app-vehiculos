<?php

namespace App\Enum;

class RoleEnum
{
  const SUPER_ADMIN = 1;
  const RECORDER    = 2;
  const SUPERVISOR  = 3;
  const SUPPLIER    = 4;

  public static function getRoleName($role)
  {
    switch ($role) {
      case self::SUPER_ADMIN:
        return 'Super Administrador';
      case self::RECORDER:
        return 'Registrador';
      case self::SUPERVISOR:
        return 'Supervisor';
      case self::SUPPLIER:
        return 'Proveedor';
      default:
        return 'No definido';
    }
  }

  public static function getRoleNameByUser($user)
  {
    return self::getRoleName($user->role_id);
  }

  // array clave valor
  public static function getArrayKeyValue(): array
  {
    return [
      'super_admin' => self::SUPER_ADMIN,
      'recorder' => self::RECORDER,
      'supervisor' => self::SUPERVISOR,
      'supplier' => self::SUPPLIER,
    ];
  }
}
