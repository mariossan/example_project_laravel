<div class="card-body table-responsive">
    <table class="table secondDash table-bordered">
        <thead class="text-info">
            <tr align="center">
                {{-- <th>Mes</th> --}}
                <th></th>
                <th>Tipo</th>
                <th>Proveedor</th>
                <th>talento</th>
                <th>Concepto</th>
                <th>Comentarios</th>
                <th>Gastos</th>
            </tr>
        </thead>
        <tbody>

            @php
                $gastoTotal     = 0;
                $auxGastoTotal  = 0;
            @endphp

            @foreach ($gastos as $gasto)

                @php
                    $auxGastoTotal   = $gastoTotal;
                    $gastoTotal     += $gasto->gasto;
                @endphp

                @if( in_array( $gasto->id,$gastos_asociados ) || $gasto->status == 1 )

                    @if( auth()->user()->hasRoles(['Ejecutivo']) )

                        @if( ( auth()->user()->id == $gasto->user_id ) )
                            @include('admin.producers.facturas._gasto', ['gasto' => $gasto ])
                        @endif

                    @else
                        @include('admin.producers.facturas._gasto', ['gasto' => $gasto ])

                    @endif

                @endif

            @endforeach
        </tbody>
    </table>
</div>
