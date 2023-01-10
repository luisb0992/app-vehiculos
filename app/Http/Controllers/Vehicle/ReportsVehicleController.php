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
            'vehicles' => $this->dbVehicle->getVehiclesReportsFilter(),
            'models' => $this->modelVehicleF->getAllModelsOrderASC(),
            'brands' => $this->brandF->getBrands(),
            'filters' => [
                'brand' => null,
                'model' => null,
                'dates' => null,
                'nro_chasis' => null,
            ],
        ]);
    }

    //Query POST
    public function queryVehicle(){

        $brand = request()->brand_id;
        $model = request()->model_id;
        $dates = request()->dates;
        $nro_chasis = request()->nro_chasis;

        //dd($brand,$model,$dates,$nro_chasis);

        return Inertia::render('Reports/Vehicle/Index',[
            'vehicles' => $this->dbVehicle->getVehiclesReportsFilter($brand,$model,$dates,$nro_chasis),
            'models' => $this->modelVehicleF->getAllModelsOrderASC(),
            'brands' => $this->brandF->getBrands(),
            'filters' => [
                'brand' => $brand,
                'model' => $model,
                'dates' => $dates,
                'nro_chasis' => $nro_chasis,
            ],
        ]);
    }

    //reporte PDF
    public function downloadPDF(): HttpResponse
    {
        $brand = request()->brand_id;
        $model = request()->model_id;
        $dates = request()->dates;
        $nro_chasis = request()->nro_chasis;

        $data = $this->dbVehicle->getVehiclesReportsFilter($brand,$model,$dates,$nro_chasis);
        $pdf = Pdf::loadView('pdf.reports.vehicle', ['vehicles' => $data,'dates' => $dates])->setPaper('a4', 'landscape');
        $name = 'reports-vehiculos-' . date('YmdHis') . '.pdf';
        return $pdf->stream($name);
    }

    //reporte EXCEL
    public function downloadEXCEL()
    {
        $brand = request()->brand_id;
        $model = request()->model_id;
        $dates = request()->dates;
        $nro_chasis = request()->nro_chasis;

        $data = $this->dbVehicle->getVehiclesReportsFilter($brand,$model,$dates,$nro_chasis);
        return Excel::download(new VehicleReportExport($data), 'reports-vehiculos.xlsx');
    }
}
