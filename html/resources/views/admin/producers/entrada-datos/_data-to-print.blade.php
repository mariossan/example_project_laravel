<div class="row" style="display: flex;justify-content: center;align-items: center;">
    <div class="card-body col-6 table-responsive float-right mt-5">
        <table class="table secondDash table-bordered">
            <thead class="text-info">
                <tr align="center">
                    <th colspan="3">
                        Presupuesto Mensual
                    </th>
                </tr>
                <tr align="center">
                    <th>Presupuesto</th>
                    <th>Pdte. aplicar</th>
                    <th>Var</th>
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
                @endforeach

                <tr align="center" class="table-secondary">
                    <td align="center"><b>{{ formatNumberEU( $month->presupuesto ) }} € </b></td>
                    <td align="center"><b>{{ formatNumberEU($gastoTotal) }} €</b></td>
                    <td align="center"><b>{{ formatNumberEU( $month->presupuesto - $gastoTotal ) }} €</b></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="card-body table-responsive">
        <table class="table secondDash table-bordered">
            <thead class="text-info">
                <tr align="center">
                    {{-- <th>Mes</th> --}}
                    <th>Tipo</th>
                    <th>Proveedor</th>
                    <th>talento</th>
                    <th>Concepto</th>
                    <th>Comentarios</th>
                    <!--th>Presupuesto</th-->
                    <th>Gastos</th>
                    <th>Usuario</th>
                    <!--th>Pdte. aplicar</th>
                    <th>Var</th-->
                    <th></th>
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

                    @if( auth()->user()->hasRoles(['Ejecutivo']) )
                        @if( ( auth()->user()->id == $gasto->user_id ) )
                            @include('admin.producers.entrada-datos._pinta_gasto', ['gasto' => $gasto ])
                        @endif
                    @else
                        @include('admin.producers.entrada-datos._pinta_gasto', ['gasto' => $gasto ])
                    @endif


                @endforeach

                <!--tr align="center" class="table-secondary">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="right"><b>{{ formatNumberEU( $month->presupuesto ) }} € </b></td>
                    <td align="right"><b>{{ formatNumberEU($gastoTotal) }} €</b></td>
                    <td align="right"><b>{{ formatNumberEU( $month->presupuesto - $gastoTotal ) }} €</b></td>
                    <td align="right"></td>
                    <td></td>
                </tr-->
            </tbody>
        </table>
    </div>
</div>
