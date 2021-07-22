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
                @include('admin.producers.campaign_dash._header',['section' => 'Dashboard'])
                <div class="row">
                    <div class="col-xl-9">
                        <div class="row">
                            @include('admin.producers.campaign_dash.generales')
                            @include('admin.producers.campaign_dash.economicos')
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="col">

                            {{-- button to add new comment --}}
                            <div class="card bitacoraDash">
                                <div class="card-header card-header-text card-header-primary">
                                    <div class="card-text">
                                        <h4 class="card-title">Bitácora</h4>
                                    </div>
                                </div>

                                <br>

                                <form action="{{ route('producers.bitacorasave') }}" method="POST" id="formBitacora">
                                    <div style="display: flex; justify-content: center;">
                                        <textarea id="summernote" name="description" required></textarea>
                                    </div>
                                    <div align="center">
                                        <a href="#" class="btn btn-primary btnSaveBitacora">Guardar</a>
                                    </div>
                                </form>

                                <hr>

                                <div class="contentBit">
                                    @foreach ($bitacora as $bitacoraItem)
                                        <div class="cuadrito">
                                            {!! $bitacoraItem->description !!}
                                            <div class="fecha">{{ $bitacoraItem->user->name }} - {{ $bitacoraItem->created_at->diffForHumans() }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row">
                    @include('admin.producers.campaign_dash.calendario')
                    @include('admin.producers.campaign_dash.tiemporeal')
                    @include('admin.producers.campaign_dash.imagen')
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <script src="{{ asset("/js/months_service.js") }}?{{ date("YmdHis") }}"></script>

    <script>
        $(function(){

            @if( session("status") )
                Swal.fire({
                    position: 'center-center',
                    text: '{{ session('status')['message'] }}',
                    icon: '{{ session('status')['status'] }}',
                    showConfirmButton: false,
                    timer: 2000
                })
            @endif

            $("#uploadFile").on("change", function(){
                $('.success').html( $(this).val() ).fadeIn("slow")
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

            $('button.mark-as-close').on('click', function(){
                let result = confirm("¿Estas seguro de realizar esta acción?");
                if( result ){
                    window.location.href = '{{ route('producers.marcar-cerrada', $campaign) }}'
                }
            })

            $('#image').change(function(){
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#preview-image-after-upload').css('display', 'none');
                    $('#preview-image-before-upload').attr('src', e.target.result);
                    $('#preview-image-before-upload').css('display', 'block');
                }
                reader.readAsDataURL(this.files[0]);
            });
        })

        $("body").on('input propertychange', '.soloNumeros', function(){
            var RegExPattern = /^\d+$/;
            $(this).val($(this).val().replace(/[[a-zA-Z\u00D1\u00F1\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC@ ]/gi, ""));
        });
    </script>

@endsection


