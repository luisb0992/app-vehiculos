@extends('pdf.layout.main')
@section('content')
    <div class="w-100">
        <div class="bg-primary" style="padding-top: 1rem; padding-bottom: 0.5rem;">
            <div class="text-white text-left col-xs-6">
                <p>
                    <b>TALLER</b>
                    <span>
                        {{ $quota->repairOrder->workshop->name }}
                    </span>
                </p>
            </div>
            <div class="text-right text-white" style="padding-right: 1rem;">
                <p>
                    <span>
                        <b>Orden de reparación</b>
                    </span>
                    Nº {{ '000' . $quota->repairOrder->id }}
                </p>
            </div>
        </div>
        <br>
        <div class="py-2">
            @include('pdf.partials.CardVehicle', [
                'vehicle' => $quota->repairOrder->vehicle,
                'gallery' => $quota->repairOrder->vehicle->gallery,
                'path' => config('storage.vehicle.resize_pp'),
            ])
        </div>
    </div>
    <br>
    <div>
        <div class="bg-info text-white p-2 rounded text-center text-uppercase"
            style="padding-top: 1rem; padding-bottom: 1rem;">
            <b>Cotización</b>
        </div>
        <div class="w-100">
            <table class="table table-bordered">
                <thead class="border-b">
                    <tr>
                        <th class="text-left font-bold py-3">
                            Items
                        </th>
                        <th class="text-center font-bold py-3">
                            Costo
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($quota->repairOrder->subcategories as $sub)
                        <tr>
                            <td class="text-left">
                                {{ $sub->name }}
                            </td>
                            <td class="text-center">
                                ${{ number_format($sub->pivot->cost, 2, '.', ',') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="flex flex-col justify-end py-5 border-t">
                <div>
                    <p class="text-right text-sm">
                        <span class="font-weight-bold"><b>Subtotal</b></span>
                        <span class="bg-light p-3 rounded">
                            ${{ number_format($quota->subtotal, 2, '.', ',') }}
                        </span>
                    </p>
                </div>
                @if ($quota->iva)
                    <div>
                        <p class="text-right text-sm">
                            <span class="font-weight-bold"><b>Impuesto</b></span>
                            <span class="bg-light p-3 rounded">
                                {{ $quota->iva ? $quota->iva . '%' : '---' }}
                            </span>
                        </p>
                    </div>
                @endif
                <div>
                    <p class="text-right text-sm">
                        <span class="font-weight-bold"><b>Total</b></span>
                        <span class="bg-light p-3 rounded">
                            ${{ number_format($quota->total, 2, '.', ',') }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
