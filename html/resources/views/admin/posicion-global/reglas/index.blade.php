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

                        <div align='center'>
                            <a class="btn btn-info" href="{{ route('posicion-global.add-rule') }}">
                                Agregar regla <span class="material-icons">rule</span>
                            </a>
                        </div>

                        <br><br>

                        <table class="table table-hover secondDash">
                            <thead class="text-info">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Proveedor</th>
                                    <th>Tipos</th>
                                    <th>Acuerdo</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($reglas as $regla)
                                    <tr>
                                        <td>{{ $regla->name }}</td>
                                        <td>{{ $regla->dealer->business_name }}</td>
                                        <td>{!! $regla->tipos !!}</td>
                                        <td>{{ $regla->acuerdo }}%</td>
                                        <td>
                                            <a class="btn btn-dark btn-sm" href="{{ route('posicion-global.edit-rule', $regla) }}">
                                                <span class="material-icons">mode_edit_outline</span>
                                            </a>
                                            <a
                                                href="{{ route('posicion-global.del-rule', $regla) }}"
                                                data-user="user1"
                                                class="btn btn-sm btn-outline-danger delRule"
                                                data-name="{{ $regla->name }}"
                                            >
                                                <span class="material-icons">delete</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10">
                                            <h3 align='center'>Sin datos para mostrar</h3>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

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
