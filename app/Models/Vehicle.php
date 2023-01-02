<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;
use App\Traits\UtilsLogs;


class Vehicle extends Model
{
    use SoftDeletes,LogsActivity,UtilsLogs;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vehicles';

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->setDescriptionForEvent(fn(string $eventName) => "Vehiculo :  {$this->eventName($eventName)}")
        ->useLogName('Vehiculo');
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->ip = request()->ip();
        $activity->user_agent = $this->nameDevicePlatorm();
    }

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
        return $this->belongsTo(ModelVehicle::class);
    }

    /**
     * Get the color that owns the vehicle.
     */
    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    /**
     * Get the user that owns the vehicle.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the gallery for the vehicle.
     *
     * @return HasMany
     */
    public function gallery(): HasMany
    {
        return $this->hasMany(GalleryVehicle::class);
    }

    /**
     * Get the repair for the vehicle.
     *
     * @return HasMany
     */
    public function repairOrders(): HasMany
    {
        return $this->hasMany(RepairOrder::class, 'vehicle_id');
    }

    //scopes querys (Model, Brand, Date Between)

    public function scopeModel($query, $model)
    {
        if ($model) {
            return $query->where('model_id', $model);
        }
    }

    public function scopeBrand($query, $brand)
    {
        if ($brand) {
            return $query->where('brand_id', $brand);
        }
    }

    public function scopeDateBetween($query, $date)
    {
        if ($date) {
            return $query->whereBetween('created_at', [$date['start'], $date['end']]);
        }
    }
    //end scopes querys (Model, Brand, Date Between)
}
