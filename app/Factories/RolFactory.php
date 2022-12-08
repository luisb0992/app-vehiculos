<?php
namespace App\Factories;


use Illuminate\Database\Eloquent\Collection;

use App\Models\Rol;

class RolFactory
{
  public function getRoles(): Collection
  {
    return Rol::all(['id', 'name']);
  }
}
