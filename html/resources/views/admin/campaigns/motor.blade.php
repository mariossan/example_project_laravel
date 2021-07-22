@extends('layouts.admin.main')

@section('css')
    <style>
        th{
            font-size: 0.9rem !important;
        }

        td {
            font-size: 0.75rem !important;
        }
    </style>

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info">
                        <h4 class="card-title ">Campañas</h4>
                    </div>


                    <div class="card-body">
                        <a class="btn btn-primary" href="{{ route('campaigns.index') }}">
                            <span class="material-icons">keyboard_arrow_left</span>
                            Regresar
                        </a>
                        <h3 align='center'>Tabla Motor - {{ $campaign->name }}</h3>
                        <hr>

                        <div align='center'>
                            <a href="{{ route('campaign.motor-expotToCSV', $campaign) }}" class="btn btn-primary">
                                Descargar Resultado
                                <span class="material-icons">sim_card_download</span>
                            </a>
                        </div>
                        <br>

                        <div class="row justify-content-md-center">
                            <div class="col-4">
                                <table class="table secondDash table-bordered">
                                    <thead>
                                        <tr align="center">
                                            <th>Ingreso Total</th>
                                            <th>Gasto Total</th>
                                            <th>Margen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr align="center">
                                            <td>{{ formatNumberEU($campaign->ingresos) }}</td>
                                            <td>{{ formatNumberEU($campaign->ppto_gastos) }}</td>
                                            <td>{{ $campaign->margen }}%</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <div class="card-body table-responsive">
                            <table class="table secondDash table-bordered">
                                <thead class="text-info">
                                    <tr align="center">
                                        {{-- <th>Mes</th> --}}
                                        <th><div align='center'>Mes</div></th>
                                        <th>Ppto Ingreso</th>
                                        <th>Ingreso real</th>
                                        <th>Ppto gasto</th>
                                        <th>Gasto real</th>
                                        <th>Margen Ppto.</th>
                                        <th>Exceso Ppto Gasto</th>
                                        {{--  <th>Importe adicional</th>  --}}
                                        <th>Prov. Gasto Generada</th>
                                        <th>Prov Acum 2</th>
                                        <th>Axu1</th>
                                        <th>% margen recal</th>
                                        <th>Gasto Ajustado P&L</th>
                                        <th>Resultado real</th>
                                        <th>Check Margen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        {{--  varaiables para sumatorias  --}}
                                        $sum_ingreso_real   = 0;
                                        $sum_ppto_gasto     = 0;
                                        $sum_gasto_real     = 0;
                                        $sum_gasto_ajustado = 0;
                                        $sum_resultado_real = 0;
                                        $final_prov_acum    = 0;
                                    ?>
                                    @foreach ($campaign->months as $month)
                                        <?php
                                            $sum_ingreso_real   += $month->ingreso_real;
                                            $sum_ppto_gasto     += $month->presupuesto;
                                            $sum_gasto_real     += $month->gasto_real;
                                            $sum_gasto_ajustado += $month->gasto_ajustado;
                                            $sum_resultado_real += $month->resultado_real;
                                            $final_prov_acum    = $month->prov_acum2;
                                        ?>
                                        <tr align="center">
                                            <td width='150px' align='left'>{{ $month->mes }}</td>
                                            <td>{{ formatNumberEU($month->ingreso) }}</td>
                                            <td>{{ formatNumberEU($month->ingreso_real) }}</td>
                                            <td>{{ formatNumberEU($month->presupuesto) }}</td>
                                            <td>{{ formatNumberEU($month->gasto_real) }}</td>
                                            <td>{{ $campaign->margen }}%</td>
                                            <td>{{ formatNumberEU($month->exceso_ppto_gato) }}</td>
                                            <td>{{ formatNumberEU($month->importe_adicional_a_provisionar) }}</td>
                                            <td>{{ formatNumberEU($month->prov_acum2) }}</td>
                                            <td>{{ formatNumberEU($month->aux1) }}</td>
                                            <td>{{ $month->margen_recalculo }}%</td>
                                            <td>{{ formatNumberEU($month->gasto_ajustado) }}</td>
                                            <td>{{ formatNumberEU($month->resultado_real) }}</td>
                                            <td>{{ $month->check_margen_real }}%</td>
                                        </tr>
                                    @endforeach
                                    <tr class="table-secondary">
                                        <td colspan="20"></td>
                                    </tr>
                                    <tr align="center" style="font-weight: bold;">
                                        <td colspan="2"></td>
                                        <td>{{ formatNumberEU($sum_ingreso_real) }}</td>
                                        <td>{{ formatNumberEU($sum_ppto_gasto) }}</td>
                                        <td>{{ formatNumberEU($sum_gasto_real) }}</td>
                                        <td>{{ $campaign->margen }}%</td>
                                        <td colspan="5"></td>
                                        <td>{{ formatNumberEU($sum_gasto_ajustado) }}</td>
                                        <td>{{ formatNumberEU($sum_resultado_real) }}</td>
                                        <td></td>
                                    </tr>
                                    <tr align="center" style="font-weight: bold">
                                        <td colspan="10"></td>
                                        <td>Ajuste prov restante</td>
                                        <td>{{ formatNumberEU($final_prov_acum) }}</td>
                                        <td colspan="10"></td>
                                    </tr>
                                    <?php
                                        $check_gasto_ajustado   = $sum_gasto_ajustado - $final_prov_acum;
                                        $check_resultado_real   = $sum_ingreso_real - $check_gasto_ajustado;
                                        try {
                                            $check_porcentaje    = ($check_resultado_real * 100) / $sum_ingreso_real;
                                        } catch (Exception $e) {
                                            $check_porcentaje    = 0;
                                        }

                                        $check_porcentaje = number_format($check_porcentaje, 2, ',', ' ');
                                    ?>
                                    <tr align="center" style="font-weight: bold">
                                        <td colspan="10"></td>
                                        <td>Check Gasto</td>
                                        <td>{{ formatNumberEU($check_gasto_ajustado) }}</td>
                                        <td>{{ formatNumberEU($check_resultado_real) }}</td>
                                        <td>{{ $check_porcentaje }}%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
