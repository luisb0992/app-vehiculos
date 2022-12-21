<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Requests\Vehicle\{CreateModelRequest, EditModelRequest};
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Factories\{ModelVehicleFactory,BrandFactory};
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\ModelVehicle;

class ModelsController extends Controller
{
    public function __construct(
        private ModelVehicleFactory $modelF,
        private BrandFactory $brandF,
    ) {
    }
    public function index()
    {
        return Inertia::render('Models/Index',[
            'models' => $this->modelF->getAllModelsOrderASC()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Models/Create',[
            'brands' =>$this->brandF->getBrands(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateModelRequest $request): RedirectResponse
    {
        ModelVehicle::create([
            'name' => $request->name,
            'brand_id' => $request->brand_id,
        ]);

        return Redirect::route('utils.models.index')->with('success', 'Modelo agregado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Inertia::render('Models/Edit',[
            'model' => $this->modelF->findModelWithId($id),
            'brands' =>$this->brandF->getBrands(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditModelRequest $request, ModelVehicle $model)
    {
        $this->modelF->updateModel($request->validated(),$model);

        return Redirect::route('utils.models.index')->with('success', 'Modelo modificado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ModelVehicle $model)
    {
        if($model->vehicles->count() >= 1){
            return Redirect::route('utils.models.index')->with('error', 'No se puede eliminar el Modelo, tiene vehiculos asociados');
        }
        $model->delete();
        return Redirect::route('utils.models.index')->with('success', 'Modelo eliminado con éxito');
    }
}
