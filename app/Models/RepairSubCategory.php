<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepairSubCategory extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'repair_sub_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'repair_category_id'];

    /**
     * Get the repair category that owns the repair sub category.
     *
     * @return BelongsTo
     */
    public function repairCategory(): BelongsTo
    {
        return $this->belongsTo(RepairCategory::class, 'repair_category_id');
    }
}
