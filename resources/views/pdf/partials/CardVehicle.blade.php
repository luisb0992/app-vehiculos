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

<div class="row" style="width: 100%; position: relative;">
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style="width: 30%; position: absolute; left: 0;">
        <img src="{{ $imgFullPath }}" class="img-thumbnail" />
    </div>
    <div class="" style="width: 70%; position: absolute; right: -5%;">
        <div>
            <table class="w-auto">
                <tr>
                    <td>
                        <span class="font-weight-bold"> Nº chasis </span>
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
                        <span class="font-weight-bold"> Marca </span>
                        <p class="text-sm bg-light p-2 rounded">
                            {{ $vehicle->brand->name }}
                        </p>
                    </td>
                    <td>
                        <span class="font-weight-bold"> Modelo </span>
                        <p class="text-sm bg-light p-2 rounded">
                            {{ $vehicle->model->name }}
                        </p>
                    </td>
                    <td>
                        <span class="font-weight-bold"> Color </span>
                        <p class="text-sm bg-light p-2 rounded">
                            {{ $vehicle->color->name }}
                        </p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
