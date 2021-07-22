<div class="col-xl-4 col-md-12">
    <div class="card">
        <div class="card-header card-header-text card-header-primary">
            <div class="card-text">
                <h4 class="card-title">Calendario facturación</h4>
            </div>
        </div>
        <div class="card-body table-responsive">
            @if( auth()->user()->hasRoles(['Administrador']) )

                <div class="row">
                    <div class="col" align='center'>Mes</div>
                    <div class="col" align='center'>Importe</div>
                    <div class="col" align='center'>Factura</div>
                    <div class="col-2"></div>
                </div>

                @foreach ($campaign->months as $key => $month)
                    <form action="{{ route('campaign.setCalendario', [$campaign, $month]) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <input type="text" value="{{ $month->mes }}" class="form-control" readonly>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control soloNumeros" placeholder="Importe" name="importe" required value='{{ formatNumberEUIpt($month->importe) }}'>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Factura" name="factura" required value='{{ $month->factura }}'>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-primary btn-sm" type="submit">
                                    <span class="material-icons">send</span>
                                </button>
                            </div>
                        </div>
                    </form>
                @endforeach
            @else
                <table class="table table-hover secondDash">
                    <thead class="text-info">
                        <tr>
                            <th>Mes</th>
                            <th>
                                <div align='right'>Importe</div>
                            </th>
                            <th>
                                <div align='center'>Factura</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($campaign->months as $key => $month)
                            <tr>
                                <td align="20%">{{ $month->mes }}</td>
                                <td align='right'>
                                    @if( $month->importe == 0 )
                                        -
                                    @else
                                        {{ formatNumberEU($month->importe) }} €
                                    @endif
                                </td>
                                <td align="center">
                                    @if( $month->factura == '' )
                                    -
                                    @else
                                        {{ $month->factura }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
