<?php

namespace App\Models\Traits\User;

use App\Enum\RoleEnum;
use Illuminate\Contracts\Database\Eloquent\Builder;

/**
 * Trait UserScope
 *
 * @author luisandev <https://luisan.dev>
 */
trait UserScope
{
  /**
   * Obtiene los usuarios por taller
   *
   * @param int $workshop_id
   * @return Builder
   */
  public function scopeByWorkshop($query, $workshop_id): Builder
  {
    return $query->where('workshop_id', $workshop_id);
  }

  /**
   * Obtiene todos los usuarios registradores y supervisores
   *
   * @return Builder
   */
  public function scopeRegisterAndSupervisor($query): Builder
  {
    return $query->whereIn('rol_id', [RoleEnum::RECORDER, RoleEnum::SUPERVISOR]);
  }

  /**
   * Devuelve los usuarios supervisores
   *
   * @return Builder
   */
  public function scopeSupervisor($query): Builder
  {
    return $query->where('rol_id', RoleEnum::SUPERVISOR);
  }

  /**
   * Devuelve los usuarios registradores
   *
   * @return Builder
   */
  public function scopeRecorder($query): Builder
  {
    return $query->where('rol_id', RoleEnum::RECORDER);
  }

  /**
   * Devuelve los usuarios proveedores
   *
   * @return Builder
   */
  public function scopeSupplier($query): Builder
  {
    return $query->where('rol_id', RoleEnum::SUPPLIER);
  }

  /**
   * Devuelve los usuarios super administradores
   *
   * @return Builder
   */
  public function scopeSuperAdmin($query): Builder
  {
    return $query->where('rol_id', RoleEnum::SUPER_ADMIN);
  }

  /**
   * Devuelve los usuarios indicados
   *
   * @param array<int> $userIDs
   * @return Builder
   */
  public function scopeUsers($query, array $userIDs): Builder
  {
    return $query->whereIn('id', $userIDs);
  }
}
