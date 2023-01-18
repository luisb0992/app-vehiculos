<?php

namespace App\Models;

use App\Traits\ScopeVehicle;
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
    use SoftDeletes, LogsActivity, UtilsLogs, ScopeVehicle;

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
            ->setDescriptionForEvent(fn (string $eventName) => "Vehiculo :  {$this->eventName($eventName)}")
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

    public function repairOrdersWithStatus(): HasMany
    {
        return $this->hasMany(RepairOrder::class, 'vehicle_id')->whereIn('status', [3, 5, 6, 7]);
    }

    public function getDockAttribute()
    {
        $dock = 0;
        foreach ($this->repairOrdersWithStatus as $repairOrder) {
            foreach ($repairOrder->subcategories as $s) {
                $dock += $s->pivot->dock == 1 ? $s->pivot->cost : 0;
            }
        }

        return $dock;
    }

    public function getWarrantyAttribute()
    {
        $warranty = 0;
        foreach ($this->repairOrdersWithStatus as $repairOrder) {
            foreach ($repairOrder->subcategories as $s) {
                $warranty += $s->pivot->warranty == 1 ? $s->pivot->cost : 0;
            }
        }
        return $warranty;
    }

    public function getMainImageAttribute()
    {
        return $this->gallery[0]->path ?? null;
    }

    public function getStatusWordAttribute()
    {
        if ($this->status == 1) {
            return "Disponible";
        } else if ($this->status == 2) {
            return "Pendiente";
        } else if ($this->status == 3) {
            return "En Mantenimiento";
        } else if ($this->status == 4) {
            return "Reparado";
        } else if ($this->status == 5) {
            return "Eliminado";
        }
    }

    public function getStatusLastOrderAttribute()
    {
        return $this->repairOrders()->latest()->first()->status ?? 0;
    }
}
