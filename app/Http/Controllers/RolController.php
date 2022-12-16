<?php

namespace App\Http\Controllers;

use App\Http\Requests\Roles\{CreateRolRequest, EditRolRequest};
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use App\Factories\{RolFactory};
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Rol;

class RolController extends Controller
{

    public function __construct(
        private RolFactory $rolF,
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Roles/Index',[
            'roles' => $this->rolF->getRoles()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Roles/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRolRequest $request): RedirectResponse
    {
        Rol::create([
            'name' => $request->name,
        ]);

        return Redirect::route('roles.create')->with('success', 'Rol agregado con éxito');
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
        return Inertia::render('Roles/Edit',[
            'rol' => $this->rolF->findRolWithId($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditRolRequest $request, Rol $role)
    {
        $this->rolF->updateRol($request->validated(),$role);

        return Redirect::route('roles.index')->with('success', 'Rol modificado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rol $role)
    {
        if($role->user){
            return Redirect::route('roles.index')->with('error', 'No se puede eliminar el Rol, tiene usuarios asociados');
        }
        $role->delete();
        return Redirect::route('roles.index')->with('success', 'Rol eliminado con éxito');
    }
}
