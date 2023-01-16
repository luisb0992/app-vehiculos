@extends('pdf.layout.main')
@section('content')
    <br>
    <div class="w-100">
        <div class="bg-info text-white p-2 rounded text-center text-uppercase" style="padding-top: 1rem; padding-bottom: 1rem;">
            <b>Reporte Vehiculo - {{ $vehicle['chassis_number'] }} </b>
        </div>
    </div>
@endsection
