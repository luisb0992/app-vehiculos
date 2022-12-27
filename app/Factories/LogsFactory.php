<?php
namespace App\Factories;
use Illuminate\Database\Eloquent\Collection;

use App\Models\Activity;

class LogsFactory
{
  // ordenar por nombre
  public function getLogs() : Collection
  {
    $data = Activity::all();

    return $data;


  }
}

