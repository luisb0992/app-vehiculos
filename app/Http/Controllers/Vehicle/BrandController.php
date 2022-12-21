<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Requests\Vehicle\{CreateBrandsRequest, EditBrandsRequest};
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Factories\{BrandFactory};
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Brand;

class BrandController extends Controller
{

    public function __construct(
        private BrandFactory $brandF,
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Brands/Index',[
            'brands' => $this->brandF->getBrands()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Brands/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBrandsRequest $request): RedirectResponse
    {
        Brand::create([
            'name' => $request->name,
        ]);

        return Redirect::route('utils.brands.index')->with('success', 'Marca agregada con éxito');
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
        return Inertia::render('Brands/Edit',[
            'brand' => $this->brandF->findBrandWithId($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditBrandsRequest $request, Brand $brand)
    {
        $this->brandF->updateBrand($request->validated(),$brand);

        return Redirect::route('utils.brands.index')->with('success', 'Marca modificada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        if($brand->vehicles->count() >= 1){
            return Redirect::route('utils.brands.index')->with('error', 'No se puede eliminar esta Marca, tiene vehiculos asociados');
        }
        $brand->delete();
        return Redirect::route('utils.brands.index')->with('success', 'Marca eliminada con éxito');
    }
}
