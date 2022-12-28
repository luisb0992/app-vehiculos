<?php
namespace App\Factories;
use Illuminate\Database\Eloquent\Collection;

//use Spatie\Activitylog\Models\Activity;
use \App\Models\User;
use App\Models\ActivityCustom;

class LogsFactory
{
  // ordenar por nombre
  public function getLogs()
  {
    $data = ActivityCustom::with(['user'])->orderBy('id', 'DESC')->get();

    $result = $data->map(function ($item, $key) {
        return[
            'module' => $item->log_name,
            'user' => $item->causer->email.' | '.$item->causer->name,
            'subject' => $item->subject->name,
            'date' => $item->created_at->diffForHumans(),
            'user_agent' => $item->user_agent
        ];
    });



    return $result;

  }
}

