<?php
namespace App\Factories;


use Illuminate\Database\Eloquent\Collection;

use App\Models\Rol;

class RolFactory
{
  public function getRoles(): Collection
  {
    return Rol::orderBy('id', 'DESC')->get(['id', 'name']);
  }

  public function findRolWithId(int $id): Rol
  {
    return Rol::findOrFail($id);
  }

  public function updateRol(array $data, $rol): bool
  {
    $rol->name = $data['name'];

    return $rol->save();
  }
}
