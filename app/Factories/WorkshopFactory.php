<?php
namespace App\Factories;

use App\Models\Workshop;
use Illuminate\Database\Eloquent\Collection;

class WorkshopFactory
{
  public function getWorkshops(): Collection
  {
    return Workshop::orderBy('id', 'DESC')->get(['id', 'name']);
  }

  public function findRolWithId(int $id): Workshop
  {
    return Workshop::findOrFail($id);
  }

  public function updateRol(array $data, $workshop): bool
  {
    $workshop->name = $data['name'];

    return $workshop->save();
  }
}

