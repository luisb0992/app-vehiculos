<?php

namespace App\Http\Controllers\Vehicle;

use Inertia\Inertia;
use App\DB\VehicleDB;
use App\Http\Controllers\Controller;
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
        $brand = request()->brand_id;
        $model = request()->model_id;
        $dates = request()->dates;

        //dd(request()->all());

        //dd($brand,$model,$dates);

        //dd($this->dbVehicle->getVehiclesReportsFilter($brand,$model,$dates));
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

    public function queryVehicle(){
        return Inertia::render('Reports/Vehicle/Index',[
            'vehicles' => $this->dbVehicle->getVehiclesByUser(),
            'models' => $this->modelVehicleF->getAllModelsOrderASC(),
            'brands' => $this->brandF->getBrands(),
        ]);
    }
}
