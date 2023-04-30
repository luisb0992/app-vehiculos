<?php

namespace App\Http\Controllers;

use App\DB\WorkshopQuoteDB;
use App\Enum\StatusRepairOrderEnum;
use App\Factories\WorkshopQuoteFactory;
use App\Http\Requests\ApproveQuotationRequest;
use App\Http\Requests\CreateInvoiceRequest;
use App\Http\Requests\CreateWorkshopQuoteRequest;
use App\Models\Quotation;
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
     * Edita una cotización siempre y cuando no esté aprobada
     *
     * @param  int  $id         id de la cotización
     * @return Response
     */
    public function editQuote(int $id): Response|RedirectResponse
    {
        $quotation = $this->db->getQuotationById($id);

        // sino existe
        if (!$quotation) {
            return redirect()
                ->route('workshop_quotes.index')
                ->with('error', 'No existe la cotización');
        }

        // si la orden ya fue aprobada no se puede editar
        if ($quotation->repairOrder->status <> StatusRepairOrderEnum::QUOTED) {
            return redirect()
                ->route('workshop_quotes.index')
                ->with('error', 'No se puede editar una cotización aprobada');
        }

        // sino editar
        return Inertia::render('WorkshopQuotes/Edit', [
            'quotation' => $quotation
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
     * Guarda los datos de una factura relacionada con una cotización
     *
     * @param  CreateInvoiceRequest  $request
     * @return RedirectResponse
     */
    public function storeInvoice(CreateInvoiceRequest $request): RedirectResponse
    {
        $quota = $this->factory->storeInvoice($request->validated());

        if ($quota) {
            return redirect()
                ->route('workshop_quotes.index')
                ->with('success', 'Datos de facturación guardados con éxito');
        }

        return redirect()
            ->route('workshop_quotes.index')
            ->with('error', 'No se pudo crear guardar los datos de facturación');
    }

    /**
     * Guarda los datos de una factura relacionada con una cotización
     *
     * @param  CreateWorkshopQuoteRequest  $request
     * @return RedirectResponse
     */
    public function update(Quotation $quotation, CreateWorkshopQuoteRequest $request): RedirectResponse
    {
        // si la orden ya fue aprobada no se puede editar
        if ($quotation->repairOrder->status <> StatusRepairOrderEnum::QUOTED) {
            return redirect()
                ->route('workshop_quotes.index')
                ->with('error', 'No se puede actualizar una cotización aprobada');
        }

        $quota = $this->factory->updateQuota($quotation, $request->validated());

        if ($quota) {
            return redirect()
                ->route('workshop_quotes.index')
                ->with('success', 'Cotización actualizada con éxito');
        }

        return redirect()
            ->route('workshop_quotes.index')
            ->with('error', 'No se pudo actualizar la cotización');
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
