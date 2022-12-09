<?php

namespace App\DB;

use App\Models\Workshop;
use Illuminate\Database\Eloquent\Collection;

class WorkshopDB
{
  // constructor
  public function __construct(
    private Workshop $workshop,
  ) {
  }

  /**
   * Get all workshops
   *
   * @return Collection
   */
  public function getAllWorkshops(): Collection
  {
    return $this->workshop->all();
  }
}
