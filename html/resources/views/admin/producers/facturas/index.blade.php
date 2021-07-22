@extends('layouts.admin.main')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-info">
                <h3 class="card-title">Bienvenido - {{ Auth::user()->name }} </h3>
                {{-- {!! json_encode(auth::user()) !!} --}}
            </div>
            <div class="card-body dashboard">
                @include('admin.producers.campaign_dash._header',['section' => 'Visor de Facturas'])

                <div class="row">
                    <div class="col" align='center'>
                        <a href="{{ route("producers.facturas-add", $campaign) }}" class="btn btn-info">
                            Añadir factura <span class="material-icons">note_add</span>
                        </a>
                    </div>
                </div>

                <hr>

                <div class="row">

                    <div class="col-xl-12 col-md-12">
                        <div class="card">
                            <div class="card-header card-header-text card-header-primary">
                                <div class="card-text">
                                    <h4 class="card-title">Visor de facturas</h4>
                                </div>
                            </div>

                            {{-- @if ( auth()->user()->hasRoles(['Administrador']) ) --}}
                                {{-- se pinta un botn de decarga de la tabla --}}
                                <div align='center'>
                                    <a href="{{ route('producers.facturas-exportToCSV', $campaign) }}" class="btn btn-primary">
                                        Descargar Tabla
                                        <span class="material-icons">sim_card_download</span>
                                    </a>
                                </div>
                            {{-- @endif --}}

                            <div class="contentTabs">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    @foreach ($campaign->months as $key => $month)
                                        <li class="nav-item">
                                            <a
                                                class="nav-link @if( $key == 0 ) active @endif"
                                                id="mes{{ $month->id }}-tab"
                                                data-toggle="tab"
                                                href="#mes{{ $month->id }}"
                                                role="tab"
                                                aria-controls="mes{{ $month->id }}"
                                                aria-selected="true"
                                                data-id="{{ $month->id }}"
                                            >
                                                {{ $month->mes }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="tab-content" id="myTabContent">

                                    @foreach ($campaign->months as $key => $month)
                                        <div class="tab-pane fade show @if( $key == 0 ) active @endif" id="mes{{ $month->id }}" role="tabpanel" aria-labelledby="home-tab">

                                            @include('admin.producers.facturas._print_bill_month', [
                                                'campaign'  => $campaign,
                                                'month'     => $month
                                            ])

                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- modals to see gastos asociados --}}
    <!-- Modal -->
    <div class="modal fade gastosFacturaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Gastos asociados</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @foreach ($campaign->months as $month)
                        @foreach ($month->facturas as $factura)
                            <div class="gastosFactura{{ $factura->id }} gastosFacturas" style="display: none;">
                                @include( 'admin.producers.facturas._gastos_asociados',[ 'gastos' => $factura->gastos, 'mes' => $month->mes ] )
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection


@section('js')

    <script>
        $(function(){
            /**
            * Metodo para hacer la lectura de los gastos asociados a la factura selecionada
            */
            $('.btnGastosFacturaModal').on('click', function(){
                $('.gastosFacturas').hide();

                let facturaID = $(this).data('factura')
                $(`.${ facturaID }`).show()
            })

            @if( session("status") )
                Swal.fire({
                    position: 'top-end',
                    text: '{{ session('status')['message'] }}',
                    icon: '{{ session('status')['status'] }}',
                    showConfirmButton: false,
                    timer: 2000
                })
            @endif


            $("body").on("click", ".delItem", function(event){

                event.preventDefault()

                let name        = $(this).data("name");
                let thisButton  = $(this)

                Swal.fire({
                    title: `Esta seguro de eliminar la factura con número ${ name }?`,
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
