<table class="table secondDash">
    <thead class="thead-info">
        <tr align="center">
            <th>Mes</th>
            <th>Importe Gasto</th>
            <th>Proveedor</th>
            <th>Descripci  n</th>
        </tr>
    </thead>
    <tbody>
        <?php $sum_gastos = 0; ?>
        @foreach ($gastos as $gasto)
            <?php $sum_gastos += $gasto->gasto; ?>
            <tr align="center">
                <td>{{ $mes }}</td>
                <td align="right">{{ $gasto->gasto }}</td>
                @if ( isset($gasto->dealer->business_name) )
                        <td>{{ $gasto->dealer->business_name }}</td>
                @else
                        <td>--</td>
                @endif
                <td>{{ $gasto->comentarios }}</td>
            </tr>
        @endforeach

        <tr align="center">
            <td>Total</td>
            <td align="right">{{ $sum_gastos }}  ^b </td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>
