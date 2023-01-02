<?php

namespace App\DB;

use App\Models\RepairCategory;
use Illuminate\Database\Eloquent\Collection;

class RepairCategoryDB
{
  // constructor
  public function __construct(
    private RepairCategory $repairCategory,
  ) {
  }

  /**
   * Get all categories
   *
   * @return Collection
   */
  public function getAllCategories(): Collection
  {
    return $this->repairCategory->with(['repairSubcategories'])->get();
  }
}
