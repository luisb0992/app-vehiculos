<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateModelVehicleRequest;
use App\Models\ModelVehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ModelVehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateModelVehicleRequest  $request
     * @return RedirectResponse
     */
    public function store(CreateModelVehicleRequest $request): RedirectResponse
    {
        ModelVehicle::create($request->validated());

        return redirect()->route('vehicle.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ModelVehicle  $modelVehicle
     * @return \Illuminate\Http\Response
     */
    public function show(ModelVehicle $modelVehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ModelVehicle  $modelVehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(ModelVehicle $modelVehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ModelVehicle  $modelVehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ModelVehicle $modelVehicle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ModelVehicle  $modelVehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(ModelVehicle $modelVehicle)
    {
        //
    }
}
