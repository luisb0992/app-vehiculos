<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;
use App\Traits\UtilsLogs;

class Quotation extends Model
{
    use LogsActivity,UtilsLogs;

    protected $table = 'quotations';
    protected $fillable = [
        'repair_order_id',
        'workshop_id',
        'user_id',
        'subtotal',
        'iva',
        'total',
        'invoice_number',
        'invoice_path',
    ];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->setDescriptionForEvent(fn(string $eventName) => "Cotización :  {$this->eventName($eventName)}")
        ->useLogName('Cotización');
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->ip = request()->ip();
        $activity->user_agent = $this->nameDevicePlatorm();
    }

    /**
     * La orden de reparación
     *
     * @return void
     */
    public function repairOrder()
    {
        return $this->belongsTo(RepairOrder::class);
    }

    /**
     * El taller que hizo la cotización
     *
     * @return void
     */
    public function workshop()
    {
        return $this->belongsTo(Workshop::class);
    }

    /**
     * El usuario que hizo la cotización
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
