@extends('pdf.layout.main')
@section('content')
    <br>
    <div class="w-100">
        <div class="bg-info text-white p-2 rounded text-center text-uppercase"
            style="padding-top: 1rem; padding-bottom: 1rem;padding-left: 1rem;text-align: left;">
            <b>Reporte Vehiculo - {{ $vehicle->chassis_number }} </b>
        </div>
        <br>
        <div class="row">
            <div class="col-xs-4">
                <img src="{{ config('storage.vehicle.resize_pp') . $vehicle->main_image }}" class="img-rounded" width="250px"
                    height="180px" />
            </div>
            <div class="col-xs-8">
                <div>
                    <table class="w-auto">
                        <tr>
                            <td>
                                <span class="font-weight-bold text-uppercase"> <b>Nº chasis</b> </span>
                                <p class="text-sm bg-light p-2 rounded">
                                    {{ $vehicle->chassis_number }}
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>
                <div>
                    <table class="w-auto">
                        <tr>
                            <td>
                                <span class="font-weight-bold text-uppercase"> <b>Marca</b> </span>
                                <p class="text-sm bg-light p-2 rounded">
                                    {{ $vehicle->brand->name }}
                                </p>
                            </td>
                            <td style="padding-left: 10px;">
                                <span class="font-weight-bold text-uppercase"> <b>Modelo</b> </span>
                                <p class="text-sm bg-light p-2 rounded">
                                    {{ $vehicle->model->name }}
                                </p>
                            </td>
                            <td style="padding-left: 10px;">
                                <span class="font-weight-bold text-uppercase"> <b>Color</b> </span>
                                <p class="text-sm bg-light p-2 rounded">
                                    {{ $vehicle->color->name }}
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
    <div class="w-100">
        <div class="bg-info text-white p-2 rounded text-center text-uppercase"
            style="padding-top: 1rem; padding-bottom: 1rem;padding-left: 1rem;text-align: left;">
            <b>Ordenes</b>
        </div>
        <div class="w-100">
            <table class="table table-bordered">
                <thead class="border-b">
                    <tr>
                        <th class="text-center font-bold py-3">
                            Taller
                        </th>
                        <th class="text-center font-bold py-3">
                            Status
                        </th>
                        <th class="text-center font-bold py-3">
                            Fecha
                        </th>
                        <th class="text-center font-bold py-3">
                            Subtotal
                        </th>
                        <th class="text-center font-bold py-3">
                            IVA
                        </th>
                        <th class="text-center font-bold py-3">
                            TOTAL
                        </th>
                        <th class="text-center font-bold py-3">
                            Nº Factura
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $subtotal = 0;
                        $iva = 0;
                        $total = 0;
                    @endphp
                    @forelse ($vehicle->repairOrders as $order)
                        @php
                            $subtotal += $order->status == 2 || $order->status == 4 ? 0 : $order->quotation->subtotal ?? 0;
                            $iva += $order->status == 2 || $order->status == 4 ? 0 : $order->quotation->iva ?? 0;
                            $total += $order->status == 2 || $order->status == 4 ? 0 : $order->quotation->total ?? 0;
                        @endphp
                        <tr>
                            <td class="text-center py-3 text-sm md:text-lg">
                                {{ $order->workshop->name }}
                            </td>

                            <td class="text-center py-3 text-sm md:text-lg">
                                {{ App\Enum\StatusRepairOrderEnum::getValueFromKey($order->status) }}
                            </td>
                            <td class="text-center py-3 text-sm md:text-lg">
                                {{ $order->send_date }}
                            </td>
                            <td class="text-center py-3 text-sm md:text-lg">
                                ${{ $order->status == 2 || $order->status == 4 ? 0 : $order->quotation->subtotal ?? 0 }}
                            </td>
                            <td class="text-center py-3 text-sm md:text-lg">
                                ${{ $order->status == 2 || $order->status == 4 ? 0 : $order->quotation->iva ?? 0 }}
                            </td>
                            <td class="text-center py-3 text-sm md:text-lg">
                                ${{ $order->status == 2 || $order->status == 4 ? 0 : $order->quotation->total ?? 0 }}
                            </td>
                            <td class="text-center py-3 text-sm md:text-lg">
                                @if ($order->quotation?->invoice_number)
                                    <span>
                                        Nº {{ $order->quotation?->invoice_number }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-3 text-sm md:text-lg">
                                No hay ordenes
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tr>
                    <td colspan="3" class="text-center py-3 text-sm md:text-lg">
                        <b>Total</b>
                    </td>
                    <td class="text-center py-3 text-sm md:text-lg">
                        <b>${{ number_format($subtotal, 2, '.', '') }}</b>
                    </td>
                    <td class="text-center py-3 text-sm md:text-lg">
                        <b>${{ number_format($iva, 2, '.', '') }}</b>
                    </td>
                    <td class="text-center py-3 text-sm md:text-lg">
                        <b>${{ number_format($total, 2, '.', '') }}</b>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <br>
    <br>
    <div class="w-100">
        <div class="bg-info text-white p-2 rounded text-center text-uppercase"
            style="padding-top: 1rem; padding-bottom: 1rem;padding-left: 1rem;text-align: left;">
            <b>Fotos</b>
        </div>
        <br>
        <br>
        @php
            $data = $vehicle->gallery;
            $gallery1 = $data->slice(0, 4);
            $gallery2 = $data->slice(4, 4);
            $gallery3 = $data->slice(8, 4);
            $gallery4 = $data->slice(12, 4);
            $gallery5 = $data->slice(16, 4);
        @endphp


        {{--  galeria - todas las fotos (hasta 20 fotos)  --}}
        @if (count($data) > 0)
            <div style="padding-top: 2px;">
                <div class="row" style="margin-right: 65px;">
                    @foreach ($gallery1 as $key => $image)
                        <div class="col-xs-3" style="padding-right: 0px !important;">
                            <img src="{{ config('storage.vehicle.resize_pp') . $image->path }}" class="img-rounded"
                                width="175px" height="120px" />
                        </div>
                    @endforeach
                </div>
                <div class="row" style="margin-right: 65px;">
                    @foreach ($gallery2 as $key => $image)
                        <div class="col-xs-3" style="padding-right: 0px !important;">
                            <img src="{{ config('storage.vehicle.resize_pp') . $image->path }}" class="img-rounded"
                                width="175px" height="120px" />
                        </div>
                    @endforeach
                </div>
                <div class="row" style="margin-right: 65px;">
                    @foreach ($gallery3 as $key => $image)
                        <div class="col-xs-3" style="padding-right: 0px !important;">
                            <img src="{{ config('storage.vehicle.resize_pp') . $image->path }}" class="img-rounded"
                                width="175px" height="120px" />
                        </div>
                    @endforeach
                </div>
                <div class="row" style="margin-right: 65px;">
                    @foreach ($gallery4 as $key => $image)
                        <div class="col-xs-3" style="padding-right: 0px !important;">
                            <img src="{{ config('storage.vehicle.resize_pp') . $image->path }}" class="img-rounded"
                                width="175px" height="120px" />
                        </div>
                    @endforeach
                </div>
                <div class="row" style="margin-right: 65px;">
                    @foreach ($gallery5 as $key => $image)
                        <div class="col-xs-3" style="padding-right: 0px !important;">
                            <img src="{{ config('storage.vehicle.resize_pp') . $image->path }}" class="img-rounded"
                                width="175px" height="120px" />
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
@endsection
