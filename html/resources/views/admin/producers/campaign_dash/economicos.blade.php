<div class="col-xl-6 col-md-12">
    <div class="card">
        <div class="card-header card-header-text card-header-primary">
            <div class="card-text">
                <h4 class="card-title">Económicos</h4>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover firstDash">
                <tbody>
                    <tr>
                        <td width='50%'>Ingresos</td>
                        <td>{{ formatNumberEU( $campaign->ingresos ) }} €</td>
                    </tr>
                    <tr>
                        <td>Presupuesto de gastos</td>
                        <td>{{ formatNumberEU( $campaign->ppto_gastos ) }} €</td>
                    </tr>
                    <tr>
                        <td>margen</td>
                        <td>{{ $campaign->margen }} %</td>
                    </tr>
                    <tr>
                        <td>&nbsp</td>
                        <td>&nbsp</td>
                    </tr>
                    <tr>
                        <td>Check ingresos</td>
                        @php
                            $sum_ingresos = 0;
                        @endphp

                        @foreach ($campaign->months as $key => $month)
                            @php
                                $sum_ingresos += $month->importe;
                            @endphp
                        @endforeach

                        <td class="@if( $sum_ingresos < $campaign->ingresos ) table-danger @else table-success @endif" align="center">
                            @if( $sum_ingresos < $campaign->ingresos )
                                -
                            @else
                                <span class="material-icons" style="color: GREEN">price_check</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @if(auth()->user()->role_id == 3)
        <div class="card">
            <div class="card-header card-header-text card-header-primary">
                <div class="card-text">
                    <h4 class="card-title">Check</h4>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover firstDash">
                    <tbody>
                        <tr>
                            <td>¿Marcar como cerrada?</td>
                            <td align="center">
                                <button class="btn mark-as-close btn-info">
                                    <span class="material-icons">
                                        check_circle
                                    </span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
