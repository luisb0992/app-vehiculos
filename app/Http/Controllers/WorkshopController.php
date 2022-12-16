<?php

namespace App\Http\Controllers;

use App\Http\Requests\Workshop\{CreateWorkshopRequest, EditWorkshopRequest};
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Factories\{WorkshopFactory};
use Inertia\Inertia;
use App\Models\Workshop;

class WorkshopController extends Controller
{
    public function __construct(
        private WorkshopFactory $workshopF,
    ) {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Workshop/Index',[
            'workshops' => $this->workshopF->getWorkshops()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Workshop/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateWorkshopRequest $request): RedirectResponse
    {
        Workshop::create([
            'name' => strtoupper($request->name),
        ]);

        return Redirect::route('workshops.index')->with('success', 'Taller agregado con éxito');
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
        return Inertia::render('Workshop/Edit',[
            'workshop' => $this->workshopF->findRolWithId($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditWorkshopRequest $request, Workshop $workshop)
    {
        $this->workshopF->updateRol($request->validated(),$workshop);

        return Redirect::route('workshops.index')->with('success', 'Taller modificado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Workshop $workshop)
    {
        if($workshop->user){
            return Redirect::route('workshops.index')->with('error', 'No se puede eliminar el taller, tiene usuarios asociados');
        }

        $workshop->delete();
        return Redirect::route('workshops.index')->with('success', 'Taller eliminado con éxito');
    }
}
