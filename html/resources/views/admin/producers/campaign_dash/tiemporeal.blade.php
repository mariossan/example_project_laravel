<div class="col-xl-4 col-md-12">
    <div class="card">
        <div class="card-header card-header-text card-header-primary">
            <div class="card-text">
                <h4 class="card-title">Resumen en tiempo real</h4>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover secondDash">
                <thead class="text-info">
                    <tr>
                        <th>Mes</th>
                        <th><div align='right'>Ingreso</div></th>
                        <th><div align='right'>Gasto</div></th>
                        {{-- <th><div align='right'>Margen</div></th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($campaign->months as $key => $month)
                        <tr>
                            <td>{{ $month->mes }}</td>
                            <td align="right">{{ formatNumberEU($month->ingreso_real) }} €</td>
                            @if ( $month->gasto_real == 0 )
                                <td align="right"> - </td>
                            @else
                                <td align="right">{{ formatNumberEU($month->gasto_real) }} €</td>
                            @endif
                            {{-- <td align="right">{{ $month->margen_recalculo }} %</td> --}}
                        </tr>
                    @endforeach
                    <tr>
                        <td>
                            Totales:
                        </td>
                        <td align="right">
                            <b>{{ formatNumberEU($campaign->months->sum('ingreso_real')) }} €</b>
                        </td>
                        <td align="right">
                            <b>{{ formatNumberEU($campaign->months->sum('gasto_real')) }} €</b>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>
