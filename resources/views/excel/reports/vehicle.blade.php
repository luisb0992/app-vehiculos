<h2>Vehiculos</h2>
<table>
    <thead>
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
                    {{  $v['status_word'] }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
