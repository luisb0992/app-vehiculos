<?php
namespace App\Factories;
use App\Models\ActivityCustom;

class LogsFactory
{
  public function getLogs()
  {
    $data = ActivityCustom::with(['user'])->orderBy('id', 'DESC')->get();

    $result = $data->map(function ($item) {
        return[
            'module' => $item->log_name,
            'user' => $item->causer?->email.' | '.$item->causer?->name.' '.$item->causer?->workshopUser(),
            'subject' => $item->subject?->name ?? '---',
            'date' => $item->created_at?->diffForHumans(),
            'date_report' => $item->created_at?->format('d-m-Y H:i:s'),
            'user_agent' => $item->user_agent ?? '---',
            'ip' => $item->ip ?? '---',
            'proceso' => $item->description
        ];
    });

    return $result;

  }
}

