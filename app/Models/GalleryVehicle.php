<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class GalleryVehicle extends Model
{
    use SoftDeletes;

    protected $table = 'gallery_vehicles';

    protected $fillable = [
        'name',
        'path',
        'vehicle_id',
    ];

    public function vehicle(): ?BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}
