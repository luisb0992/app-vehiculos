<div class="row">
    <div class="col-xs-4">
        <img src="{{ $path . $gallery[0]['path'] }}" class="img-rounded" width="260px" height="180px" />
    </div>
    <div class="col-xs-8">
        <div>
            <table class="table table-bordered" style="width: 428px;">
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
            <table class="table table-bordered" style="width: 428px;">
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

@php
    $data = $gallery;
    $gallery1 = $data->slice(0, 4);
    $gallery2 = $data->slice(4, 4);
    $gallery3 = $data->slice(8, 4);
    $gallery4 = $data->slice(12, 4);
    $gallery5 = $data->slice(16, 4);
@endphp


{{--  galeria - todas las fotos (hasta 20 fotos)  --}}
@if (count($gallery) > 1)
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
