<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepairVehicleCategory extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'repair_vehicle_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'repair_category_id',
        'repair_sub_category_id',
        'repair_order_id',
        'dock',
        'warranty',
    ];

    // caster para los campos booleanos
    protected $casts = [
        'dock' => 'boolean',
        'warranty' => 'boolean',
    ];

    /**
     * Get the repair category that owns the repair vehicle category.
     *
     * @return BelongsTo
     */
    public function repairCategory(): BelongsTo
    {
        return $this->belongsTo(RepairCategory::class, 'repair_category_id');
    }

    /**
     * Get the repair sub category that owns the repair vehicle category.
     *
     * @return BelongsTo
     */
    public function repairSubCategory(): BelongsTo
    {
        return $this->belongsTo(RepairSubCategory::class, 'repair_sub_category_id');
    }

    /**
     * Get the repair order that owns the repair vehicle category.
     *
     * @return BelongsTo
     */
    public function repairOrder(): BelongsTo
    {
        return $this->belongsTo(RepairOrder::class, 'repair_order_id');
    }
}
