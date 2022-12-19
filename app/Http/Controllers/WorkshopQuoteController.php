<?php

namespace App\Http\Controllers;

use App\DB\WorkshopQuoteDB;
use App\Factories\WorkshopQuoteFactory;
use App\Http\Requests\CreateWorkshopQuoteRequest;
use App\Models\WorkshopQuote;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response as HttpResponse;

class WorkshopQuoteController extends Controller
{

    public function __construct(
        private WorkshopQuoteDB $db,
        private WorkshopQuoteFactory $factory
    ) {
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
     * Guarda una nueva cotización para un vehículo
     * y un taller
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(CreateWorkshopQuoteRequest $request): RedirectResponse
    {
        $quota = $this->factory->storeQuota($request->validated());

        if ($quota) {
            return redirect()
                ->route('workshop_quotes.index')
                ->with('success', 'Cotización creada con éxito');
        }

        return redirect()
            ->route('workshop_quotes.index')
            ->with('error', 'No se pudo crear la cotización');
    }

    /**
     * Descarga la cotización en formato pdf
     *
     * @param  int  $id
     * @return HttpResponse
     */
    public function downloadQuote(int $id): HttpResponse
    {
        // crear pdf
        $data = $this->db->getQuotationByID($id);
        $pdf = Pdf::loadView('pdf.quotation', ['quota' => $data]);
        $name = 'cotización-' . $id . '.pdf';
        return $pdf->stream($name);
    }
}
