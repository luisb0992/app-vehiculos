<?php

namespace App\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Collection;

class BrandFactory
{
  // ordenar por nombre
  public function getBrands(): Collection
  {
    return Brand::orderBy('name')->get(['id', 'name']);
  }
}
