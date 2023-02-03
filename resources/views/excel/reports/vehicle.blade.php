<h2>Vehiculos</h2>
<table>
    <thead class="border-b">
        <tr>
            <th class="text-center font-bold py-3" colspan="5">

            </th>
            <th class="text-center font-bold py-3" colspan="3">
                Monto Reparación
            </th>

        </tr>
    </thead>
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
                Usuario R.
            </th>
            <th class="text-center font-bold py-3">
                Status de Reparación
            </th>
            <th class="text-center font-bold py-3">
                Muelle
            </th>
            <th class="text-center font-bold py-3">
                Garantía
            </th>
            <th class="text-center font-bold py-3">
                Total
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($vehicles as $v)
            <tr>
                <td class="text-center py-3 text-sm md:text-lg">
                    {{ $v['chassis_number'] }}
                </td>
                <td class="text-center py-3 text-sm md:text-lg">
                    {{  $v['brand'] ?? '---' }}
                </td>
                <td class="text-center py-3 text-sm md:text-lg">
                    {{  $v['model'] ?? '---' }}
                </td>
                <td class="text-center py-3 text-sm md:text-lg">
                    {{  $v['user'] }}
                </td>
                <td class="text-center py-3 text-sm md:text-lg">
                    {{  $v['status_last_order'] }}
                </td>
                <td class="text-center py-3 text-sm md:text-lg">
                    ${{  number_format($v['dock'],2,',','.') }}
                </td>
                <td class="text-center py-3 text-sm md:text-lg">
                    ${{  number_format($v['warranty'],2,',','.') }}
                </td>
                <td class="text-center py-3 text-sm md:text-lg">
                    ${{  number_format($v['total'],2,',','.') }}
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="8"></td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td class="text-center font-bold py-3" colspan="5">
                Total
            </td>
            <td class="text-center font-bold py-3">
                ${{ number_format($vehicles->sum('dock'),2,',','.') }}
            </td>
            <td class="text-center font-bold py-3">
                ${{ number_format($vehicles->sum('warranty'),2,',','.') }}
            </td>
            <td class="text-center font-bold py-3">
                ${{ number_format($vehicles->sum('total'),2,',','.') }}
            </td>
        </tr>
</table>
