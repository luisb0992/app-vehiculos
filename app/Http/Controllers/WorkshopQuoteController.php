<?php

namespace App\Http\Controllers;

use App\DB\WorkshopQuoteDB;
use App\Factories\WorkshopQuoteFactory;
use App\Http\Requests\ApproveQuotationRequest;
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

    /**
     * Aprobar una cotización
     *
     * @param  ApproveQuotationRequest  $request
     * @return RedirectResponse
     */
    public function approveQuotation(ApproveQuotationRequest $request): RedirectResponse
    {
        $quota = $this->factory->approveQuotation($request->validated());

        if (!$quota) {
            return redirect()
                ->route('vehicle.index')
                ->with('error', 'No se pudo aprobar la cotización.');
        }

        return redirect()
            ->route('vehicle.index')
            ->with('success', 'Cotización aprobada con éxito.');
    }

    /**
     * Iniciar una orden de reparación
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function startRepair(Request $request): RedirectResponse
    {
        $this->factory->startRepair($request->all());

        return redirect()->route('workshop_quotes.index');
    }

    /**
     * finalizar una orden de reparación
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function finishRepair(Request $request): RedirectResponse
    {
        $this->factory->finishRepair($request->all());

        return redirect()->route('workshop_quotes.index');
    }

    /**
     * finalizar el caso de ordenes de reparación
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function finalizedCase(Request $request): RedirectResponse
    {
        $finalized = $this->factory->finalizedCase($request->all());

        if (!$finalized) {
            return redirect()
                ->route('vehicle.index')
                ->with('error', 'No se pudo finalizar el caso. verifique las ordenes de reparación.');
        }

        return redirect()
            ->route('vehicle.index')
            ->with('success', 'Caso finalizado con éxito.');
    }
}
