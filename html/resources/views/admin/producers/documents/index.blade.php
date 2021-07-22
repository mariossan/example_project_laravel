@extends('layouts.admin.main')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-info">
                <h3 class="card-title">Bienvenido - {{ Auth::user()->name }} </h3>
                {{-- {!! json_encode(auth::user()) !!} --}}
            </div>
            <div class="card-body dashboard">
                @include('admin.producers.campaign_dash._header',['section' => 'Documentación'])

                <div class="row">
                    <div class="col" align='center'>
                        <a href="{{ route("producers.documentacion-add", $campaign) }}" class="btn btn-info">
                            Agregar <span class="material-icons">add_circle_outline</span>
                        </a>
                    </div>
                </div>

                <hr>

                <div class="row justify-content-md-center">

                    <div class="col-xl-8 col-md-12">
                        <div class="card">
                            <div class="card-header card-header-text card-header-primary">
                                <div class="card-text">
                                    <h4 class="card-title">Documentación</h4>
                                </div>
                            </div>


                            {{-- @if ( auth()->user()->hasRoles(['Administrador']) ) --}}
                                {{-- se pinta un botn de decarga de la tabla --}}
                                <div align='center'>
                                    <a href="{{ route('producers.documentacion-exportToCSV', $campaign) }}" class="btn btn-primary">
                                        Descargar Tabla
                                        <span class="material-icons">sim_card_download</span>
                                    </a>
                                </div>
                            {{-- @endif --}}


                            <div class="card-body table-responsive">

                                <table class="table table-hover secondDash">
                                    <thead class="text-info">
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th width='150px'>Fecha</th>
                                            <th>Usuario</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($documents as $document)
                                            @if ( $document->status == 1 )
                                                <tr>
                                                    <td>
                                                        <a href="{{ asset("/storage/documents/campaign$campaign->id/$document->file") }}" target="_blank" /*data-toggle="modal" data-target="#advertisers" class='viewPDF'*/>{{ $document->name }}</a>
                                                    </td>
                                                    <td>{!! $document->description !!}</td>
                                                    <td>{{ $document->created_at->diffForHumans() }}</td>
                                                    <td>{{ $document->user->name }}</td>
                                                    <td align='center'>
                                                        <a href="{{ route('producers.documentacion-edit', [$campaign, $document]) }}" class="btn btn-outline-dark btn-sm">
                                                            <span class="material-icons">mode_edit_outline</span>
                                                        </a>

                                                        <a
                                                            href="{{ route('producers.documentacion-delete', [$campaign, $document]) }}"
                                                            class="btn btn-outline-danger btn-sm delItem"
                                                            data-name='{{ $document->name }}'
                                                        >
                                                            <span class="material-icons">delete</span>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $documents->links() }}
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row justify-content-md-center">

                    <div class="col-xl-8 col-md-12">
                        <div class="card bitacoraDash" style="padding-bottom: 2rem">
                            <div class="card-header card-header-text card-header-primary">
                                <div class="card-text">
                                    <h4 class="card-title">Descripción de Campaña</h4>
                                </div>
                            </div>

                            <br>

                            <div class="row">
                                <div class="col-xl-6" style="border-right: 1px solid #ccc">
                                    <form action="{{ route('producers.bitacorasave-doc') }}" method="POST" id="formBitacora">
                                        <div style="display: flex; justify-content: center;">
                                            <textarea id="summernote" name="description" required></textarea>
                                        </div>
                                        <div align="center">
                                            <a href="#" class="btn btn-primary btnSaveBitacora">Guardar</a>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-xl-6">
                                    <div class="contentBit" style="padding-right: 2rem; padding-left: 1rem">
                                        @foreach ($bitacora as $bitacoraItem)
                                            <div class="cuadrito" style="margin-bottom: 20px">
                                                <span>{!! $bitacoraItem->description !!}</span>
                                                <div class="fecha">{{ $bitacoraItem->user->name }} - {{ $bitacoraItem->created_at->diffForHumans() }}</div>
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
    </div>

    {{-- modals to see gastos asociados --}}
    <!-- Modal -->
    <div class="modal fade" id="advertisers" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Factura</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- <iframe class="iframe" src="https://docs.google.com/gview?url={{ asset('/storage/documentacion/etiquetas.pdf') }}&embedded=true" style="width:100%; height:100vh;" frameborder="0"></iframe> --}}
                    <iframe class="iframe" src="" style="width:100%; height:100vh;" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(function(){
            $('.viewPDF').on("click", function(){
                let pdf = $(this).attr('href');

                $('.iframe').attr('src', `https://docs.google.com/gview?url=${ pdf }&embedded=true`);
            })

            $('#summernote').summernote({
                width: "90%",
                height: 100,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                ]
            });

            $('.btnSaveBitacora').on("click", function(){
                let actionForm = $('#formBitacora').attr("action");
                let dataToSend = {
                    '_token': "{{ csrf_token() }}",
                    'campaign_id': "{{ $campaign->id }}",
                    'description': $("#summernote").summernote("code")
                }

                {{-- se activa la llamada al loader --}}
                $('.backLoader').css('display', 'flex');

                $.post( actionForm, dataToSend, function(resp) {
                    $('.backLoader').fadeOut('fast');
                    $('.contentBit').prepend(` <div class="cuadrito">
                                                    ${ resp.description }
                                                    <div class="fecha">${ resp.producer.name } -  ${ resp.desde }</div>
                                                </div>`);

                    $('#summernote').summernote('code', '');
                    console.log( resp )
                }, 'json' );

            });


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
