
<tr align="center">
    {{--  <td>{{ $month->mes }}</td>  --}}
    <td>{{ $factura->no_factura }}</td>
    <td align="right">{{ formatNumberEU($factura->importe_bruto) }} €</td>
    <td align="right">{{ formatNumberEU($factura->importe_neto) }} €</td>
    <td>
        <a href="#" class="btn btn-info btn-sm btnGastosFacturaModal" data-toggle="modal" data-target=".gastosFacturaModal" data-factura="gastosFactura{{ $factura->id }}">
            Ver gastos
        </a>
    </td>
    <td>SI</td>
    <td>{{ $factura->condiciones_pago }} días</td>
    <td>{{ ( $factura->ok_pago ) ? "SI" : "NO" }}</td>
    <td>
        <a class="btn btn-primary btn-sm" href="{{ asset('/storage/facturas/campaign') }}{{ $campaign->id }}/{{ $factura->file }}" target="_blank">Ver</a>
    </td>
    <td>
        @if( ($factura->user_id == auth()->user()->id && $month->status == 1) || auth()->user()->hasRoles(['Administrador']) )
            <a href="{{ route('producers.facturas-edit', [$campaign, $factura]) }}" class="btn btn-outline-dark btn-sm">
                <span class="material-icons">mode_edit_outline</span>
            </a>

            <a
                href="{{ route('producers.facturas-delete', [$campaign, $factura]) }}"
                class="btn btn-outline-danger btn-sm delItem"
                data-name="{{ $factura->no_factura }}"
            >
                <span class="material-icons">delete</span>
            </a>
        @endif
    </td>
</tr>

