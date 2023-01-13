{{--  <div class="d-flex justify-content-start">
    <div class="">
        <img src="{{ $imgFullPath }}" class="w-full h-full object-cover object-center rounded aspect-video" />
    </div>
    <div class="">
        <div class="flex flex-wrap justify-start md:px-4">
            <div class="w-full pb-2">
                <label class="text-zinc-800 font-bold"> Nº chasis</label>
                <p class="bg-zinc-200 p-2 rounded text-sm">
                    {{ $vehicle->chassis_number }}
                </p>
            </div>
            <div class="">
                <label class="text-zinc-800 font-bold"> Marca </label>
                <p class="bg-zinc-200 p-2 rounded text-sm">
                    {{ $vehicle->brand->name }}
                </p>
            </div>
            <div class="w-4/12 pr-3">
                <label class="text-zinc-800 font-bold"> Modelo </label>
                <p class="bg-zinc-200 p-2 rounded text-sm">
                    {{ $vehicle->model->name }}
                </p>
            </div>
            <div class="w-4/12">
                <label class="text-zinc-800 font-bold"> Color </label>
                <p class="bg-zinc-200 p-2 rounded text-sm">
                    {{ $vehicle->color->name }}
                </p>
            </div>
        </div>
    </div>
</div>  --}}

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
                    <td>
                        <span class="font-weight-bold text-uppercase"> <b>Modelo</b> </span>
                        <p class="text-sm bg-light p-2 rounded">
                            {{ $vehicle->model->name }}
                        </p>
                    </td>
                    <td>
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
<br>
<div class="row">
    @foreach ($quota->repairOrder->vehicle->gallery as $key => $image)
        @if ($key == 0)
            @continue
        @endif
        <div class="col-xs-3 text-left pull-left">
            <img src="{{ config('storage.vehicle.resize_pp') . $image->path }}" class="img-rounded" width="160px" height="120px" />
        </div>
    @endforeach
</div>
