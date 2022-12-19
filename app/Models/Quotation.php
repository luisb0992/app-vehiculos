<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $table = 'quotations';
    protected $fillable = [
        'repair_order_id',
        'workshop_id',
        'user_id',
        'subtotal',
        'iva',
        'total',
    ];

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
