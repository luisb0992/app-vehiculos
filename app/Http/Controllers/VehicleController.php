<?php

namespace App\Http\Controllers;

use App\DB\RepairCategoryDB;
use App\DB\VehicleDB;
use App\DB\WorkshopDB;
use App\Factories\BrandFactory;
use App\Factories\ColorFactory;
use App\Factories\ModelVehicleFactory;
use App\Factories\VehicleFactory;
use App\Http\Requests\CreateOrderRepairRequest;
use App\Http\Requests\CreateVehicleRequest;
use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class VehicleController extends Controller
{

    // constructor
    public function __construct(
        private BrandFactory $brandF,
        private ColorFactory $colorF,
        private ModelVehicleFactory $modelF,
        private VehicleFactory $vehicleF,
        private VehicleDB $db,
        private RepairCategoryDB $dbCat,
        private WorkshopDB $dbShop,
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Vehicle/Index', [
            'vehicles' => $this->db->getVehiclesByUser(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Vehicle/Create', [
            'brands' => $this->brandF->getBrands(),
            'colors' => $this->colorF->getColors(),
            'models' => $this->modelF->getAllModels(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateVehicleRequest $request): RedirectResponse
    {
        // guardar vehículo
        $vehicle = $this->vehicleF->createVehicle($request->validated());

        // guardar imagenes
        $this->vehicleF->saveGallery($vehicle, $request->gallery);

        // devolver un json con el vehículo creado
        // pasar los datos del vehículo
        return Redirect::route('vehicle.repair', ['id' => $vehicle->id])
            ->with('success', 'Vehículo creado correctamente, ya puedes solicitar una reparación.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicle $vehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehicle $vehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehicle $vehicle)
    {
        //
    }


    /**
     * Solicitar reparación de un vehículo
     *
     * @param int $id
     */
    public function repair(int $id): Response
    {
        return Inertia::render('Vehicle/Repair', [
            'vehicle' => $this->db->getVehicleByIdWithRelation($id),
            'categories' => $this->dbCat->getAllCategories(),
            'workshops' => $this->dbShop->getAllWorkshops(),
        ]);
    }

    /**
     * ALmacena los datos de la reparación
     *
     * @param CreateOrderRepairRequest $request
     * @return RedirectResponse
     */
    public function storeRepair(CreateOrderRepairRequest $request): RedirectResponse
    {
        $orders = $this->vehicleF->storeRepair($request->validated());

        if ($orders === null) {
            return Redirect::route('vehicle.repair', ['id' => $request->vehicle_id])
                ->with('error', 'No se pudo generar la orden de reparación, verifique los datos.');
        }

        return Redirect::route('vehicle.index')
            ->with('success', 'Orden(es) generadas correctamente.');
    }
}
