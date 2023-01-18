@extends('pdf.layout.main')
@section('content')
    <br>
    <div class="w-100">
        <div class="bg-info text-white p-2 rounded text-center text-uppercase" style="padding-top: 1rem; padding-bottom: 1rem;">
            <b>Reporte Vehiculo - {{ $vehicle->chassis_number }} </b>
        </div>
        <div class="row">
            <div class="col-xs-4">
                @foreach ($vehicle->gallery as $p)
                    <img src="{{ config('storage.vehicle.resize_pp') . $p->path }}" class="img-rounded" width="100px" height="80px" />
                @endforeach

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
@endsection
