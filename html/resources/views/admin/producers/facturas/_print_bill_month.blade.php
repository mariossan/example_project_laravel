<div class="card-body table-responsive">
    <table class="table table-hover secondDash table-bordered">
        <thead class="text-info">
            <tr align="center">
                {{--  <th>Mes</th>  --}}
                <th>No. de Factura</th>
                <th>Importe bruto</th>
                <th>Importe neto</th>
                <th>Gastos asociados</th>
                <th>Aplicada Totalmente</th>
                <th>Condiciones de pago</th>
                <th>OK Pago?</th>
                <th>PDF</th>
                <th></th>
            </tr>
        </thead>
        <tbody>

            @foreach ($month->facturas as $factura)
                @if ( $factura->status == 1 )
                    @if( auth()->user()->hasRoles(['Ejecutivo']) )
                        @if( ( auth()->user()->id == $factura->user_id ) )
                            @include('admin.producers.facturas._bills')
                        @endif
                    @else
                        @include('admin.producers.facturas._bills')
                    @endif
                @endif
            @endforeach

        </tbody>
    </table>
</div>
