<?php

namespace App\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Collection;

class BrandFactory
{
  // ordenar por nombre
  public function getBrands(): Collection
  {
    return Brand::orderBy('id', 'DESC')->get(['id', 'name']);
  }

  public function findBrandWithId(int $id): Brand
  {
    return Brand::findOrFail($id);
  }

  public function updateBrand(array $data, $brand): bool
  {
    $brand->name = $data['name'];

    return $brand->save();
  }
}
