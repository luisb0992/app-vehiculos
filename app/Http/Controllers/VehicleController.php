<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRepairRequest;
use App\Http\Requests\CreateVehicleRequest;
use Illuminate\Support\Facades\Redirect;
use App\Factories\ModelVehicleFactory;
use Illuminate\Http\RedirectResponse;
use App\Factories\VehicleFactory;
use App\Factories\ColorFactory;
use App\Factories\BrandFactory;
use Barryvdh\DomPDF\Facade\Pdf;
use App\DB\RepairCategoryDB;
use App\DB\WorkshopDB;
use App\DB\VehicleDB;
use Inertia\Response;
use Inertia\Inertia;

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
        return Inertia::render('Vehicle/Create');
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

        if (!$vehicle) {
            return Redirect::back()->with('error', 'El vehículo ya fue registrado.');
        }

        // guardar imagenes
        $this->vehicleF->saveGallery($vehicle, $request->gallery);

        // devolver un json con el vehículo creado
        // pasar los datos del vehículo
        return Redirect::route('vehicle.repair', ['id' => $vehicle->id])
            ->with('success', 'Vehículo creado correctamente, ya puedes solicitar una reparación.');
    }

    /**
     * Solicitar reparación de un vehículo
     *
     * @param int $id
     */
    public function repair(int $id): Response|RedirectResponse
    {
        if (!$this->db->getVehicleById($id)) {
            abort(404);
        }

        // verificar que el vehículo no posea ya alguna orden de reparación
        if ($this->db->checkVehicleHasRepairOrders($id)) {
            return Redirect::route('vehicle.index')
                ->with('error', 'El vehículo ya posee orden de reparación.');
        }

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
