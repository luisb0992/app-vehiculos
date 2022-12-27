<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Activity;
use App\Factories\LogsFactory;

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
}
