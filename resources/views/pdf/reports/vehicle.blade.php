@extends('pdf.layout.main')
@section('content')
    <br>
    <div class="w-100">
        <div class="bg-success text-white p-2 rounded text-center text-uppercase">
            Vehiculos del {{ $dates['start'] }} - {{ $dates['end'] }}
        </div>
        <div class="w-100">
            <table class="table table-bordered">
                <thead class="border-b">
                    <tr>
                        <th class="text-center font-bold py-3">
                            Nº chasis
                        </th>
                        <th class="text-center font-bold py-3">
                            Marca
                        </th>
                        <th class="text-center font-bold py-3">
                            Modelo
                        </th>
                        <th class="text-center font-bold py-3">
                            Color
                        </th>
                        <th class="text-center font-bold py-3">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vehicles as $v)
                        <tr>
                            <td class="text-center py-3 text-sm md:text-lg">
                                {{ $v->chassis_number }}
                            </td>
                            <td class="text-center py-3 text-sm md:text-lg">
                                {{  $v->brand->name ?? '---' }}
                            </td>
                            <td class="text-center py-3 text-sm md:text-lg">
                                {{  $v->model->name ?? '---' }}
                            </td>
                            <td class="text-center py-3 text-sm md:text-lg">
                                {{  $v->color->name ?? '---' }}
                            </td>
                            <td class="text-center py-3 text-sm md:text-lg">
                                {{  $v->statusVehicle() }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
