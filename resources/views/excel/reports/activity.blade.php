<h2>Bítacora del sistema</h2>
<table>
    <thead>
        <tr>
            <th style="font-weight: bold;font-size: 12px;">
                Modulo
            </th>
            <th style="font-weight: bold;font-size: 12px;">
                Usuario
            </th>
            <th style="font-weight: bold;font-size: 12px;">
                Sujeto
            </th>
            <th style="font-weight: bold;font-size: 12px;">
                Fecha
            </th>
            <th style="font-weight: bold;font-size: 12px;">
                Plataforma
            </th>
            <th style="font-weight: bold;font-size: 12px;">
                IP
            </th>
            <th style="font-weight: bold;font-size: 12px;">
                Proceso
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($logs as $log)
            <tr>
                <td class="text-center py-3 text-sm md:text-lg">
                    {{ $log['module'] }}
                </td>
                <td class="text-center py-3 text-sm md:text-lg">
                    {{ $log['user'] }}
                </td>
                <td class="text-center py-3 text-sm md:text-lg">
                    {{ $log['subject'] }}
                </td>
                <td class="text-center py-3 text-sm md:text-lg">
                    {{ $log['date_report'] }}
                </td>
                <td class="text-center py-3 text-sm md:text-lg">
                    {{ $log['user_agent'] }}
                </td>
                <td class="text-center py-3 text-sm md:text-lg">
                    {{ $log['ip'] }}
                </td>
                <td class="text-center py-3 text-sm md:text-lg">
                    {{ $log['proceso'] }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
