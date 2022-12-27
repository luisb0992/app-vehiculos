<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;
use App\Traits\DeviceDetected;

class Workshop extends Model
{
    use SoftDeletes,LogsActivity,DeviceDetected;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'workshops';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['name', 'user.name'])
        ->useLogName('Taller');
        // Chain fluent methods for configuration options
    }

    public function tapActivity(Activity $activity, string $eventName)
    {

        $activity->ip = request()->ip();
        $activity->user_agent = $this->nameDevicePlatorm();
    }

    public function user(){
        return $this->hasOne(User::class);
    }
}
