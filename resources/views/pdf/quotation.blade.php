@extends('pdf.layout.main')
@section('content')
    <div class="w-100">
        <div class="text-white text-center text-uppercase">
            <p class="bg-primary" style="padding-top: 1rem; padding-bottom: 1rem;">
                Nombre del taller:
                <span class="font-weight-bold">
                    <b>{{ $quota->repairOrder->workshop->name }}</b>
                </span>
            </p>
        </div>
        <div class="py-2">
            @include('pdf.partials.CardVehicle', [
                'vehicle' => $quota->repairOrder->vehicle,
                'gallery' => $quota->repairOrder->vehicle->gallery,
                'path' => config('storage.vehicle.resize_pp'),
            ])
        </div>
    </div>
    <br>
    <div class="w-100">
        <div class="bg-warning text-white p-2 rounded text-center text-uppercase" style="padding-top: 1rem; padding-bottom: 1rem;">
            <b>Cotización</b>
        </div>
        <div class="w-100">
            <table class="table table-bordered">
                <thead class="border-b">
                    <tr>
                        <th class="text-center font-bold py-3">
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
                            <td class="text-center py-3 text-sm md:text-lg">
                                {{ $sub->name }}
                            </td>
                            <td class="text-center py-3 text-sm md:text-lg">
                                {{ $sub->pivot->cost }}
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
                            {{ number_format($quota->subtotal, 2, ',', '.') }}
                        </span>
                    </p>
                </div>
                <div>
                    <p class="text-right text-sm">
                        <span class="font-weight-bold"><b>Impuesto</b></span>
                        <span class="bg-light p-3 rounded">
                            {{ $quota->iva }} %
                        </span>
                    </p>
                </div>
                <div>
                    <p class="text-right text-sm">
                        <span class="font-weight-bold"><b>Total</b></span>
                        <span class="bg-light p-3 rounded">
                            {{ number_format($quota->total, 2, ',', '.') }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
