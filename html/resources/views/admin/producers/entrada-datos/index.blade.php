@extends('layouts.admin.main')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-info">
                <h3 class="card-title">Bienvenido - {{ Auth::user()->name }} </h3>
                {{-- {!! json_encode(auth::user()) !!} --}}
            </div>
            <div class="card-body dashboard">
                @include('admin.producers.campaign_dash._header',['section' => 'Entrada de datos'])

                <div class="row">
                    <div class="col" align='center'>
                        <a href="{{ route("producers.gastos", $campaign) }}" class="btn btn-info btn-add-gasto">
                            Añadir gasto <span class="material-icons">attach_money</span>
                        </a>

                        <a href="{{ route("producers.facturas", $campaign) }}" class="btn btn-info">
                            Ver facturas <span class="material-icons">remove_red_eye</span>
                        </a>
                    </div>
                </div>

                <hr>

                <div class="row">

                    <div class="col-xl-12 col-md-12">
                        <div class="card">
                            <div class="card-header card-header-text card-header-primary">
                                <div class="card-text">
                                    <h4 class="card-title">Datos</h4>
                                </div>
                            </div>

                            {{-- @if ( auth()->user()->hasRoles(['Administrador', 'Producer']) ) --}}
                                {{-- se pinta un botn de decarga de la tabla --}}
                                <div align='center'>
                                    <a href="{{ route('producers.export-entrada-datos', $campaign) }}" class="btn btn-primary">
                                        Descargar Tabla
                                        <span class="material-icons">sim_card_download</span>
                                    </a>
                                </div>
                            {{-- @endif --}}


                            <div class="contentTabs">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    @foreach ($campaign->months as $key => $month)
                                        <li class="nav-item">
                                            <a class="nav-link @if( $key == 0 ) active @endif" id="mes{{ $month->id }}-tab" data-toggle="tab" href="#mes{{ $month->id }}" role="tab" aria-controls="mes{{ $month->id }}" aria-selected="true" data-id="{{ $month->id }}">{{ $month->mes }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="tab-content" id="myTabContent">

                                    @foreach ($campaign->months as $key => $month)
                                        <div class="tab-pane fade show @if( $key == 0 ) active @endif" id="mes{{ $month->id }}" role="tabpanel" aria-labelledby="home-tab">
                                            @include('admin.producers.entrada-datos._data-to-print', [
                                                'month'     => $month,
                                                'gastos'    => $month->gastos ])
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


@endsection

@section('js')
    <script>
        $(function(){
            @if( session("status") )
                Swal.fire({
                    position: 'top-end',
                    text: '{{ session('status')['message'] }}',
                    icon: '{{ session('status')['status'] }}',
                    showConfirmButton: false,
                    timer: 2000
                })
            @endif

            var itemId = 0;

            {{--  validacion para cuando cambiamos de tab se asigna el nuevo ID del mismo  --}}
            $('.nav-item a').on('click', function(){
                itemId =  $(this).data('id')
            })

            {{--  Se agrega el valor de ID a la url del gasto para poderla recibir  --}}
            $('.btn-add-gasto').on('click', function(event){
                event.preventDefault();

                let urlToSend           = $(this).attr('href')
                window.location.href    = `${urlToSend}/${itemId}`
            })

            $('.btn-destroy').on('click', function(event) {
                event.preventDefault();
                let result = confirm("¿Estas seguro de realizar esta acción?");
                if(result){
                    $(this).parent().submit();
                }
            });
        })
    </script>
@endsection
