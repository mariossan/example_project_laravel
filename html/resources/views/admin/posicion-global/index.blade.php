@extends('layouts.admin.main')

@section('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

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
        <div class="row justify-content-md-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info">
                        <h4 class="card-title">POSICIÓN GLOBAL</h4>
                    </div>
                    <div class="card-body">

                        <br>
                        <h2 align='center'>Tabla Posición Global</h2>
                        <br>

                        <form action="{{ route('posicion-global.getList') }}" method="POST">
                            @csrf
                            <div class="row justify-content-md-center">
                                <div class="col-lg-2">
                                    <div>
                                        <label>Mes</label>
                                        <select class="selectpicker form-control" data-live-search="true" name="mes" required>
                                            <option value="">Seleccione</option>
                                            @foreach ($months as $month)
                                                <option value="{{ $month }}" @if( $month == $mes ) selected @endif>{{ $month }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div>
                                        <label>Año</label>
                                        <select class="selectpicker form-control" data-live-search="true" name="anio" required>
                                            <option value="">Seleccione</option>
                                            @for ($i = date('Y') - 1; $i < date('Y') + 2; $i++)
                                                <option value="{{ $i }}" @if( $i == $anio ) selected @endif>{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <div class="row justify-content-md-center">
                                <button type="submit" class="btn btn-primary">Obtener</button>
                            </div>
                        </form>


                        <br>
                        <hr>

                        @if ( count($info) > 0 )
                            <div align='center'>
                                <a href="{{ route('posicion-global.downloadCSV', [$mes, $anio]) }}" class="btn btn-primary">
                                    Descargar Tabla
                                    <span class="material-icons">sim_card_download</span>
                                </a>
                            </div>
                            <br>
                        @endif

                        <div class="row">
                            <table class="table table-hover secondDash table-bordered">
                                <thead class="text-info">
                                    <tr align="center">
                                        <th>ID Camp.</th>
                                        <th width='150px'>Nombre Campaña</th>
                                        <th width='150px'>Cliente</th>
                                        <th width='150px'>Anunciante</th>
                                        <th><div align='center'>Ingreso Real</div></th>
                                        <th>Ing. Aux1</th>
                                        <th><div align='center'>Talentos</div></th>
                                        <th><div align='center'>Prod. Interna</div></th>
                                        <th><div align='center'>Prod. Externa</div></th>
                                        <th><div align='center'>Delivery</div></th>
                                        <th><div align='center'>Prov. Gasto Generada</div></th>
                                        <th>Res 1</th>
                                        <th>Res 2</th>
                                        <th>Producers</th>
                                        <th>Ultima Fecha Mod.</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $estados = ["Eliminada", "Activa", "Pausada", "Cerrada"];
                                        $coloresEstados = ["danger", "success", "info", "secondary"];
                                    @endphp

                                    @forelse ($info as $infoItem)
                                        <tr align="center">
                                            <td>
                                                <a href="{{ route('campaign.motor', $infoItem->campaign) }}" target="_blank">ID {{ $infoItem->campaign->id }}</a>
                                            </td>
                                            <td>
                                                <a href="{{ route('producers.resumen', $infoItem->campaign) }}" target="_blank">{{ $infoItem->campaign->name }}</a>
                                            </td>
                                            <td>{{ $infoItem->campaign->client->business_name }}</td>
                                            <td>{{ $infoItem->campaign->advertiser->name }}</td>
                                            <td>{{ formatNumberEU( $infoItem->info["ingresoReal"] ) }}€</td>
                                            <td>{{ formatNumberEU( $infoItem->info["ingAux1"] ) }}€</td>
                                            <td>{{ formatNumberEU( $infoItem->info["talentos"] ) }}€</td>
                                            <td>{{ formatNumberEU( $infoItem->info["prodInterna"] ) }}€</td>
                                            <td>{{ formatNumberEU( $infoItem->info["prodExterna"] ) }}€</td>
                                            <td>{{ formatNumberEU( $infoItem->info["delivery"] ) }}€</td>
                                            <td>{{ formatNumberEU( $infoItem->info["provGastoGenerada"] ) }}€</td>
                                            <td>{{ formatNumberEU( $infoItem->info["resultado1"] ) }}€</td>
                                            <td>{{ formatNumberEU( $infoItem->info["resultado2"] ) }}€</td>
                                            <td>
                                                <a href="#" data-toggle="modal" data-target="#exampleModal{{ $infoItem->id }}">
                                                    Ver
                                                </a>
                                                @include('admin.posicion-global._modal', ['infoItem' => $infoItem])
                                            </td>
                                            <td>{{ $infoItem->updated_at }}</td>
                                            <td class="table-{{ $coloresEstados[$infoItem->campaign->status] }}">{{ $estados[$infoItem->campaign->status] }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="20" align='center'>
                                                <h3>Sin datos para mostrar</h3>
                                            </td>
                                        </tr>
                                    @endforelse

                                    @if ( count( $info ) > 0 )
                                        <tr class="table-secondary" style="font-weight: bold" align="center">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>{{ formatNumberEU($results["sumIngresoReal"]) }}€</td>
                                            <td>{{ formatNumberEU($results["sumIngAux1"]) }}€</td>
                                            <td>{{ formatNumberEU($results["sumTalentos"]) }}€</td>
                                            <td>{{ formatNumberEU($results["sumProdInterna"]) }}€</td>
                                            <td>{{ formatNumberEU($results["sumProdExterna"]) }}€</td>
                                            <td>{{ formatNumberEU($results["sumDelivery"]) }}€</td>
                                            <td>{{ formatNumberEU($results["sumProvGastoGenerada"]) }}€</td>
                                            <td>{{ formatNumberEU($results["sumResultado1"]) }}€</td>
                                            <td>{{ formatNumberEU($results["sumResultado2"]) }}€</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection


@section('js')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ asset("/js/months_service.js") }}?{{ date("YmdHis") }}"></script>
    <script src="{{ asset("/js/utilities.js") }}?{{ date("YmdHis") }}"></script>
    <script>
        $(function() {

            @if( session("status") )
                Swal.fire({
                    position: 'top-end',
                    text: '{{ session('status')['message'] }}',
                    icon: '{{ session('status')['status'] }}',
                    showConfirmButton: false,
                    timer: 2000
                })
            @endif

            $('.selectpicker').selectpicker();

            setTimeout(function(){
                $('.dropdown-toggle').click();
            },200);

            $("body").on('input propertychange', '.soloNumeros', function(){
                var RegExPattern = /^\d+$/;
                $(this).val($(this).val().replace(/[[a-zA-Z\u00D1\u00F1\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC@ ]/gi, ""));
            });

            /**
             * Method to del item
             * */
             $("body").on("click", ".delRule", function(event){

                event.preventDefault()

                let name        = $(this).data("name");
                let thisButton  = $(this)

                Swal.fire({
                    title: `Esta seguro de eliminar la regla ${ name }?`,
                    // text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                       window.location.href = $(thisButton).attr('href');
                    }

                })
            })

        })
    </script>
@endsection
