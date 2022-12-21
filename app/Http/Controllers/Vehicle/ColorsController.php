<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Requests\Vehicle\{CreateColorsRequest, EditColorsRequest};
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Factories\{ColorFactory};
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Color;

class ColorsController extends Controller
{
    public function __construct(
        private ColorFactory $colorF,
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Color/Index',[
            'colors' => $this->colorF->getColors()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Color/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateColorsRequest $request): RedirectResponse
    {
        Color::create([
            'name' => $request->name,
        ]);

        return Redirect::route('utils.colors.index')->with('success', 'Color agregado con éxito');
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
        return Inertia::render('Color/Edit',[
            'color' => $this->colorF->findRolWithId($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditColorsRequest $request, Color $color)
    {
        $this->colorF->updateColor($request->validated(),$color);

        return Redirect::route('utils.colors.index')->with('success', 'Color modificado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Color $color)
    {
        if($color->vehicles->count() >= 1){
            return Redirect::route('utils.colors.index')->with('error', 'No se puede eliminar el Color, tiene vehiculos asociados');
        }
        $color->delete();
        return Redirect::route('utils.colors.index')->with('success', 'Color eliminado con éxito');
    }
}
