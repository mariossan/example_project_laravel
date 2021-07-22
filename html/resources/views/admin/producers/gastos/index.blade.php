@extends('layouts.admin.main')


@section('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <style>
        .btnClose {
            position: absolute;
            top: -10px;
            right: -10px;
            display: block;
            color: #ffffff;
            width: 20px;
            height: 20px;
            background: #a7372f;
            border-radius: 20px;
            text-align: center;
            text-decoration: none;
        }
    </style>
@endsection


@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-info">
                <h3 class="card-title">Bienvenido - {{ Auth::user()->name }} </h3>
                {{-- {!! json_encode(auth::user()) !!} --}}
            </div>
            <div class="card-body dashboard">
                <div class="row justify-content-md-center">
                    <h3 class="titleCampaign">Añadir gasto</h3>
                </div>

                <div class="row">
                    <div class="col" align='left'>
                        <a href="{{ route("producers.entrada-datos", $campaign) }}" class="btn btn-light">
                            Regresar <span class="material-icons">arrow_back</span>
                        </a>
                    </div>
                </div>

                <div class="row justify-content-md-center">
                    <div class="col-xl-12 col-md-12">
                        <div class="card">
                            <div class="card-header card-header-text card-header-primary">
                                <div class="card-text">
                                    <h4 class="card-title">AGREGAR</h4>
                                </div>
                            </div>

                            <br>


                            <div class="row justify-content-center alerts-cards">
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-11">
                                    <form action="{{ route('producers.gastos-save', $campaign) }}" method="POST">
                                        @csrf
                                        @include('admin.producers.gastos._form', ['btnName' => 'Enviar'])
                                    </form>
                                    <br>
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

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function(){
            $( "#datepicker" ).datepicker({
                "dateFormat": "yy-mm-dd"
            });

            setTimeout(function(){
                $('.dropdown-toggle').click();
                $('.from,.to').change();
            },200);


            $("body").on('input propertychange', '.soloNumeros', function(){
                var RegExPattern = /^\d+$/;
                $(this).val($(this).val().replace(/[[a-zA-Z\u00D1\u00F1\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC@ ]/gi, ""));
            });

            {{-- leemos los influencers --}}
            let influencer_alertas = {!! json_encode( $influencer_alertas ) !!}

            {{-- leemos los delaers --}}
            let dealer_alertas      = {!! json_encode( $dealer_alertas ) !!}


            $('body').on('click', '.btnClose', function(){
                $('.alert-danger').fadeOut('fast');
            })

            $('.dealerSelect').on('changed.bs.select', function(){
                let valor = $(this).val()

                if ( valor != '') {
                    $('.alert-danger').hide()
                    $.each( dealer_alertas, function(key, value) {
                        if ( valor == value.id ) {
                            $('.alert-msg-danger').html( value.warning )
                            $('.alert-danger').fadeIn('slow')
                        }
                    })
                }
            })



            $('#influencerSelect').on('changed.bs.select', function(){
                $('.alerts-cards').empty();
                $('select#influencerSelect :selected').map(function(index,select){
                    influencer_alertas.map(function(alerta){
                        if(alerta.id == $(select).val()){
                            let influencer = `${alerta.name} ${alerta.lastname}`;
                            //$('.selectpicker').selectpicker('deselectAll');
                            alerta.available_alerts.map(function(alert){
                                let card = `<div class="col-lg-4">
                                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                    <strong>${influencer}</strong>
                                                    <br>
                                                    ${alert.title}, del ${alert.start_at.split('T').shift()} al ${alert.end_at.split('T').shift()}
                                                    ${alert.description}
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            </div>`;
                                $('.alerts-cards').append( card );
                            })
                        }
                    })
                })
            })

        })
    </script>
@endsection
