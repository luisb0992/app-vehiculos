<?php

namespace App\Http\Controllers\Vehicle;

use Inertia\Inertia;
use App\DB\VehicleDB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Exports\VehicleReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Response as HttpResponse;
use App\Factories\{ModelVehicleFactory,BrandFactory,ColorFactory};

class ReportsVehicleController extends Controller
{
    public function __construct(
        private ModelVehicleFactory $modelVehicleF,
        private BrandFactory $brandF,
        private ColorFactory $colorF,
        private VehicleDB $dbVehicle,
    ) {
    }

    public function index()
    {

        return Inertia::render('Reports/Vehicle/Index',[
            'vehicles' => $this->dbVehicle->getVehiclesReportsFilter(null,null,null),
            'models' => $this->modelVehicleF->getAllModelsOrderASC(),
            'brands' => $this->brandF->getBrands(),
            'filters' => [
                'brand' => null,
                'model' => null,
                'dates' => null,
            ],
        ]);
    }

    //Query POST
    public function queryVehicle(){

        $brand = request()->brand_id;
        $model = request()->model_id;
        $dates = request()->dates;

        return Inertia::render('Reports/Vehicle/Index',[
            'vehicles' => $this->dbVehicle->getVehiclesReportsFilter($brand,$model,$dates),
            'models' => $this->modelVehicleF->getAllModelsOrderASC(),
            'brands' => $this->brandF->getBrands(),
            'filters' => [
                'brand' => $brand,
                'model' => $model,
                'dates' => $dates,
            ],
        ]);
    }

    //reporte PDF
    public function downloadPDF(): HttpResponse
    {
        $brand = request()->brand_id;
        $model = request()->model_id;
        $dates = request()->dates;

        $data = $this->dbVehicle->getVehiclesReportsFilter($brand,$model,$dates);
        $pdf = Pdf::loadView('pdf.reports.vehicle', ['vehicles' => $data,'dates' => $dates])->setPaper('a4', 'landscape');
        $name = 'reports-vehiculos-' . date('YmdHis') . '.pdf';
        return $pdf->stream($name);
    }

    public function downloadEXCEL()
    {
        $brand = request()->brand_id;
        $model = request()->model_id;
        $dates = request()->dates;

        $data = $this->dbVehicle->getVehiclesReportsFilter($brand,$model,$dates);
        return Excel::download(new VehicleReportExport($data), 'reports-vehiculos.xlsx');
    }
}
