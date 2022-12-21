<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelVehicle extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'model_vehicles';

    protected $guarded = [];

    /**
     * Devuelve la marca del vehículo.
     *
     * @return BelongsTo
     */
    public function brand(): ?BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class,'model_id');
    }
}
