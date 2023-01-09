<?php

namespace App\Factories;

use App\Models\Color;
use Illuminate\Database\Eloquent\Collection;

class ColorFactory
{
  // ordenar por nombre
  public function getColors(): Collection
  {
    return Color::orderBy('name', 'ASC')->get(['id', 'name']);
  }

  public function findRolWithId(int $id): Color
  {
    return Color::findOrFail($id);
  }

  public function updateColor(array $data, $color): bool
  {
    $color->name = $data['name'];

    return $color->save();
  }
}
