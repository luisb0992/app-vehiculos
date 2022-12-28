<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;

class ActivityCustom extends Activity
{
    use HasFactory;

    //protected $table = 'activity_log';

    public function user()
    {
        //dd($this->morphTo());
        return $this->belongsTo(User::class,'causer_id');
    }

}
