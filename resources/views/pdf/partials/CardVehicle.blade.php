<div class="row">
    <div class="col-xs-4">
        <img src="{{ $path . $gallery[0]['path'] }}" class="img-rounded" width="260px" height="180px" />
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

{{--  galeria - todas las fotos (hasta 20 fotos)  --}}
<div style="padding-top: 2px;">
    <div class="row" style="margin-right: 65px;">
        @foreach ($quota->repairOrder->vehicle->gallery->slice(0, 4) as $key => $image)
            {{--  @if ($key == 0)
            @continue
        @endif  --}}
            <div class="col-xs-3" style="padding-right: 0px !important;">
                <img src="{{ config('storage.vehicle.resize_pp') . $image->path }}" class="img-rounded" width="175px"
                    height="120px" />
            </div>
        @endforeach
    </div>
    <div class="row" style="margin-right: 65px;">
        @foreach ($quota->repairOrder->vehicle->gallery->slice(4, 8) as $key => $image)
            <div class="col-xs-3" style="padding-right: 0px !important;">
                <img src="{{ config('storage.vehicle.resize_pp') . $image->path }}" class="img-rounded" width="175px"
                    height="120px" />
            </div>
        @endforeach
    </div>
    <div class="row" style="margin-right: 65px;">
        @foreach ($quota->repairOrder->vehicle->gallery->slice(8, 12) as $key => $image)
            <div class="col-xs-3" style="padding-right: 0px !important;">
                <img src="{{ config('storage.vehicle.resize_pp') . $image->path }}" class="img-rounded" width="175px"
                    height="120px" />
            </div>
        @endforeach
    </div>
    <div class="row" style="margin-right: 65px;">
        @foreach ($quota->repairOrder->vehicle->gallery->slice(12, 16) as $key => $image)
            <div class="col-xs-3" style="padding-right: 0px !important;">
                <img src="{{ config('storage.vehicle.resize_pp') . $image->path }}" class="img-rounded" width="175px"
                    height="120px" />
            </div>
        @endforeach
    </div>
    <div class="row" style="margin-right: 65px;">
        @foreach ($quota->repairOrder->vehicle->gallery->slice(16, 20) as $key => $image)
            <div class="col-xs-3" style="padding-right: 0px !important;">
                <img src="{{ config('storage.vehicle.resize_pp') . $image->path }}" class="img-rounded" width="175px"
                    height="120px" />
            </div>
        @endforeach
    </div>
</div>
