<?php
namespace App\Factories;

use App\Models\Workshop;
use Illuminate\Database\Eloquent\Collection;

class WorkshopFactory
{
  // ordenar por nombre
  public function getWorkshops(): Collection
  {
    return Workshop::all(['id', 'name']);
  }
}

