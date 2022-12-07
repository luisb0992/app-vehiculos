<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vehicles';

    protected $guarded = [];

    /**
     * Get the brand that owns the vehicle.
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the model that owns the vehicle.
     */
    public function model(): BelongsTo
    {
        return $this->belongsTo(Model::class);
    }

    /**
     * Get the color that owns the vehicle.
     */
    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    /**
     * Get the gallery for the vehicle.
     */
    public function gallery()
    {
        return $this->hasMany(GalleryVehicle::class);
    }
}
