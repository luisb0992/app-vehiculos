<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Activity;
use App\Factories\LogsFactory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response as HttpResponse;

class ActivityLogController extends Controller
{
    public function __construct(
        private LogsFactory $logsF,
    ) {
    }

    public function index(){
        return Inertia::render('Activity/Index',[
            'logs' => $this->logsF->getLogs()
        ]);
    }


    public function downloadPDF(): HttpResponse
    {
        $data = $this->logsF->getLogs();
        $pdf = Pdf::loadView('pdf.logs-activity.pdf', ['logs' => $data])->setPaper('a4', 'landscape');
        $name = 'logs-' . date('YmdHis') . '.pdf';
        return $pdf->stream($name);
    }
}
