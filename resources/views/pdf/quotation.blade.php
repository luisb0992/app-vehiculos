@extends('pdf.layout.main')
@section('content')
    <div class="w-100">
        <div class="bg-primary text-white p-2 rounded text-center text-uppercase">
            Nombre del taller:
            <span class="font-weight-bold">
                {{ $quota->repairOrder->workshop->name }}
            </span>
        </div>
        <div class="py-2">
            @include('pdf.partials.CardVehicle', [
                'vehicle' => $quota->repairOrder->vehicle,
                'imgFullPath' =>
                    config('storage.vehicle.resize_pp') . $quota->repairOrder->vehicle->gallery[0]['path'],
            ])
        </div>
    </div>
    <br><br><br><br><br><br><br>
    <div class="w-100">
        <div class="bg-success text-white p-2 rounded text-center text-uppercase">
            Cotización
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
                        <span class="font-weight-bold">Subtotal</span>
                        <span class="bg-light p-3 rounded">
                            {{ number_format($quota->subtotal, 2, ',', '.') }}
                        </span>
                    </p>
                </div>
                <div>
                    <p class="text-right text-sm">
                        <span class="font-weight-bold">Impuesto</span>
                        <span class="bg-light p-3 rounded">
                            {{ $quota->iva }} %
                        </span>
                    </p>
                </div>
                <div>
                    <p class="text-right text-sm">
                        <span class="font-weight-bold">Total</span>
                        <span class="bg-light p-3 rounded">
                            {{ number_format($quota->total, 2, ',', '.') }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
