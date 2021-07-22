@extends('layouts.admin.main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info">
                        <h4 class="card-title ">Influencers - Alertas</h4>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-4">
                                <a class="btn btn-primary" href="{{ route('alerts.create', $influencer) }}">
                                    Agregar
                                    <span class="material-icons">assignment_ind</span>
                                </a>
                            </div>
                            <div class="col-md-4"></div>
                        </div>

                        <br><br>

                        <div class="row justify-content-md-center">

                            <div class="col-lg-10">
                                <div class="table-responsive">
                                    <table class="table" id="influencers_datatable">
                                        <thead class=" text-primary">
                                            <tr>
                                                <th>Titulo</th>
                                                <th>Descripción</th>
                                                <th>Inicio</th>
                                                <th>Fin</th>
                                                <th>Estatus</th>
                                                <th>
                                                    <div align='right'>Acciones</div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="tbody">
                                            @foreach($influencer->alerts as $alert)
                                                <tr>
                                                    <td>{{ $alert->title }}</td>
                                                    <td>
                                                        {!! $alert->description !!}
                                                    </td>
                                                    <td>{{ $alert->start_at->format('Y-m-d') }}</td>
                                                    <td>{{ $alert->end_at->format('Y-m-d') }}</td>
                                                    <td>
                                                        <span class="badge {{ $alert->status ? 'badge-success' : 'badge-warning' }}">
                                                            {{ $alert->getStatus() }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('alerts.edit',$alert) }}" class="btn btn-sm btn-outline-success">
                                                            <span class="material-icons">edit</span>
                                                        </a>

                                                        <form action="{{ route('alerts.destroy',$alert) }}"
                                                              method="POST"
                                                              style="display: inline-block;"
                                                        >
                                                            @csrf
                                                            @method('DELETE')
                                                            <a class="btn btn-delete-alert btn-sm btn-danger text-white">
                                                                <span class="material-icons">delete</span>
                                                            </a>
                                                        </form>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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





            /**
             * Method to del user
             * */
            $("body").on("click", ".delItem", function(event){

                event.preventDefault()

                let name        = $(this).data("name");
                let thisButton  = $(this)

                Swal.fire({
                    title: `Esta seguro de eliminar a ${ name }?`,
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


            /**
             *
             * Method:   Metodo para poder recolertar la informacion del item seleccionado
             *           y poder mostrar la alerta en caso de existr o si no para poderla guardar
             *
             **/
            var influencer_id = 0;
            $("body").on("click", ".alertItem", function(event){
                event.preventDefault()
                influencer_id = $(this).data('id')
                $('.influencer_id').val( influencer_id )
                $('.alertaText').val( $(this).data('alerta') ).change()
                $('.modal-body span').html( $(this).data('name') );
            })

            $('#formAlerta').on('submit', function(event){
                event.preventDefault();

                {{-- se hace la lectura de informacion para el envio por ajax --}}
                let urlToSend   = $(this).attr('action');
                let dataToSend  = $(this).serialize();
                var alerta      = $(this).serializeArray()[1].value


                $.post( urlToSend, dataToSend, function(resp){


                    {{-- cierra la modal  --}}
                    $('.close').click()

                    {{-- manda el mensaje despues del cambio --}}
                    Swal.fire({
                        position: 'top-end',
                        icon: `${ resp.status }`,
                        text: `${ resp.message }`,
                        showConfirmButton: false,
                        timer: 2000
                    })

                    if ( resp.status == 'success' ) {
                        {{-- se hace el cambio de color de boton en caso de ser necesario --}}
                        $(`.alertItem${ influencer_id }`).removeClass('btn-warning');
                        $(`.alertItem${ influencer_id }`).removeClass('btn-outline-dark');

                        if ( alerta == "" ) {
                            $(`.alertItem${ influencer_id }`).addClass('btn-outline-dark');
                        } else {
                            $(`.alertItem${ influencer_id }`).addClass('btn-warning');
                        }


                        {{-- se cambia el texto del boton igualmente para lo que usa la modal --}}
                        $(`.alertItem${ influencer_id }`).data('alerta', alerta);
                    }
                }, 'json' )

                return false;
            })

            $('#influencers_datatable').DataTable({
                language : {
                    url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                }
            });

            $('.btn-delete-alert').on('click', function(event) {
                event.preventDefault();
                let thisLink  = $(this)
                Swal.fire({
                    title: `¿Esta seguro de eliminar esta alerta?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(thisLink).parent().submit();
                    }

                })
            });

        })
    </script>
@endsection
