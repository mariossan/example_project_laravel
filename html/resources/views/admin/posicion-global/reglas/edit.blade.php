@extends('layouts.admin.main')

@section('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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

                        <div align='left'>
                            <a class="btn btn-ligth" href="{{ route('posicion-global.rules-index') }}">
                                Regresar
                            </a>
                        </div>

                        <hr>

                        <h2 align='center'>Editar Regla</h2>
                        <br>

                        <div class="row justify-content-md-center">
                            <div class="col-8">
                                <form action="{{ route("posicion-global.update-rule", $rule) }}" method="POST">
                                    @csrf
                                    @include('admin.posicion-global.reglas._form', ['btn' => 'Actualizar'])
                                </form>
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

        })
    </script>
@endsection
