<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ActivityExport implements FromView
{
    public function __construct(
        private $data,
    ) {
    }

    public function view(): View
    {
        return view('excel.reports.activity', [
            'logs' => $this->data
        ]);
    }
}
