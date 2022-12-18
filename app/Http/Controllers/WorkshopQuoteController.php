<?php

namespace App\Http\Controllers;

use App\DB\WorkshopQuoteDB;
use App\Models\WorkshopQuote;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class WorkshopQuoteController extends Controller
{

    public function __construct(private WorkshopQuoteDB $db)
    {
    }

    /**
     * Devuelve las ordenes de cotización por taller
     *
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('WorkshopQuotes/Index', [
            'orders' => $this->db->getAllByWorkshop()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function createQuote(int $id): Response
    {
        return Inertia::render('WorkshopQuotes/Create', [
            'order' => $this->db->getOrderById($id)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WorkshopQuote  $workshopQuote
     * @return \Illuminate\Http\Response
     */
    public function show(WorkshopQuote $workshopQuote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WorkshopQuote  $workshopQuote
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkshopQuote $workshopQuote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkshopQuote  $workshopQuote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkshopQuote $workshopQuote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WorkshopQuote  $workshopQuote
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkshopQuote $workshopQuote)
    {
        //
    }
}
