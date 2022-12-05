<?php

namespace App\Factories;

use App\Models\Color;
use Illuminate\Database\Eloquent\Collection;

class ColorFactory
{
  // ordenar por nombre
  public function getColors(): Collection
  {
    return Color::orderBy('name')->get(['id', 'name']);
  }
}
