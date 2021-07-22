@extends('layouts.admin.main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info">
                        <h4 class="card-title ">Campañas</h4>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-4">
                                <a class="btn btn-primary" href="{{ route('campaigns.create') }}">
                                    Agregar
                                    <span class="material-icons">assignment_ind</span>
                                </a>
                            </div>
                        </div>

                        <br><br>
                        <div class="row justify-content-md-center">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table secondDash table-bordered" id="campaigns_datatable">
                                        <thead class=" text-primary">
                                            <tr align="center">
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Fecha de inicio</th>
                                                <th>Fecha de Fin</th>
                                                <th>Meses</th>
                                                <th>Estado</th>
                                                <th>
                                                    <div align='right'>Acciones</div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="tbody">
                                            @php
                                                $estados = ["", "Activa", "Pausada", "Cerrada"];
                                                $coloresEstados = ["", "success", "info", "secondary"];
                                            @endphp
                                            @foreach ($campaigns as $dataItem)
                                                <tr align="center">
                                                    <td>{{ $dataItem->id }}</td>
                                                    <td>{{ $dataItem->name }}</td>
                                                    <td>{{ $dataItem->month_start }}</td>
                                                    <td>{{ $dataItem->month_end }}</td>
                                                    <td>{{ $dataItem->total_months }}</td>
                                                    <td class="table-{{ $coloresEstados[$dataItem->status] }}">{{ $estados[$dataItem->status] }}</td>
                                                    <td align="right">
                                                        <a href="{{ route('producers.resumen', $dataItem) }}" class='btn btn-outline-warning btn-sm'>
                                                            <span class="material-icons">remove_red_eye</span>
                                                        </a>

                                                        <a href="{{ route('campaigns.edit', $dataItem) }}" class="btn btn-sm btn-outline-success">
                                                            <span class="material-icons">edit</span>
                                                        </a>

                                                        <a href='{{ route('campaign.motor', $dataItem) }}' class='btn btn-outline-info btn-sm'>
                                                            <span class="material-icons">engineering</span>
                                                        </a>

                                                        <button
                                                            type="button"
                                                            class='btn btn-outline-primary btn-sm btnGetMonths'
                                                            data-toggle="modal"
                                                            data-target="#CampaignsMonths"
                                                            data-id="{{ $dataItem->id }}"
                                                            data-name="{{ $dataItem->name }}"
                                                        >
                                                            <span class="material-icons">calendar_today</span>
                                                        </button>


                                                        <a
                                                        href="{{ route('campaign.delete', $dataItem) }}"
                                                        data-user="user{{ $dataItem->id }}"
                                                        class="btn btn-sm btn-outline-danger delItem"
                                                        data-name="{{ $dataItem->name }}"
                                                        >
                                                            <span class="material-icons">delete</span>
                                                        </a>

                                                        <button
                                                            class="btn btn-sm btn-dark statusCampaignsbtn"
                                                            data-toggle="modal"
                                                            data-target=".statusCampaigns"
                                                            data-campaign="{{ $dataItem->id }}"
                                                            data-status="{{ $dataItem->status }}"
                                                            data-campaignname="{{ $dataItem->name }}"
                                                        >
                                                            . . .
                                                        </button>
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


    <!-- Modal -->
    <div class="modal fade" id="CampaignsMonths" tabindex="-1" aria-labelledby="CampaignsMonthsLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="CampaignsMonthsLabel">Modal title</h5>
            </div>
            <div class="modal-body">
                <div class="row campaignsMonths">
                    <div class="col-10"></div>
                    <div class="col-2"><span class="material-icons">stop_circle</span></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btnCloseModal" data-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade statusCampaigns" tabindex="-1" aria-labelledby="statusCampaigns" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusCampaignsTitle">Modal title</h5>
            </div>
            <div class="modal-body">
                Estado actual - <span class="actualStatus"></span>
                <hr>
                <form action="#" id="formNewState" method="POST">
                    @csrf
                    <div class="row justify-content-md-center">
                        <div class="col6">
                            <select name="newState" id="newStatte" class="selectpicker">
                                <option value="1">Activar</option>
                                <option value="2">Pausar</option>
                                <option value="3">Cerrar</option>
                            </select>
                        </div>
                    </div>

                    <div class="row  justify-content-md-center">
                        <button class="button btn btn-primary">Enviar</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btnCloseModal" data-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
    </div>

@endsection


@section('js')

    <script src="{{ asset("/js/months_service.js") }}?{{ date("YmdHis") }}"></script>

    <script>
        $(function() {

            var urlToSend       = "{{ url('/') }}";

            @if( session("status") )
                Swal.fire({
                    position: 'top-end',
                    text: '{{ session('status')['message'] }}',
                    icon: '{{ session('status')['status'] }}',
                    showConfirmButton: false,
                    timer: 2000
                })
            @endif

            /***********************************
            *           SEARCH SECTION
            ***********************************/
            setTimeout(function(){
                $('.dropdown-toggle').click()
            },200);

            $('.statusCampaignsbtn').on("click", function(){
                let estados = [
                    "",
                    "Activa",
                    "Pausada",
                    "Cerrada"
                ];

                let estadoActual = estados[$(this).data("status")]
                $(".actualStatus").html(estadoActual)
                $("#statusCampaignsTitle").html( $(this).data("campaignname") )
                let id = $(this).data("campaign");

                $("#formNewState").attr("action", `${ urlToSend }/campaigns/${ id }/moveStatus`);
            })



            /**
             * Method to del item
             * */
             $("body").on("click", ".delItem", function(event){

                event.preventDefault()

                let name        = $(this).data("name");
                let thisButton  = $(this)

                Swal.fire({
                    title: `Esta seguro de eliminar la campaña ${ name }?`,
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

            $("body").on("click", ".btnGetMonths", function(){
                let campaign_id     = $(this).data('id')
                var campaignName    = $(this).data('name')

                $('.campaignsMonths').html('')

                $.get( `${ urlToSend }/campaigns/${ campaign_id }/getMonts`, [], function(resp){

                    $('#CampaignsMonthsLabel').html( `Campaña - ${campaignName}` );

                    {{--  se hace el pintado de informacion --}}
                    $.each( resp, function(key, item){
                        $('.campaignsMonths').append(`
                            <div class="col-5">${ item.mes }</div>
                            <div class="col-1">
                                <a
                                    href="#"
                                    style="color: ${ ( item.status == 0 )? "RED" : "GREEN" }"
                                    class='${ ( item.status == 0 )? "openMonth" : "closeMonth" }'
                                    data-id='${ item.id }'
                                >
                                    <span class="material-icons">lock_open</span>
                                </a>
                            </div>
                            <div class="col-6"></div>
                            <hr>
                        `)
                    })

                }, 'json')
            })



            $("body").on("click", ".closeMonth", function(){
                let campaign_month = $(this).data('id');
                $.get( `${ urlToSend }/campaigns/${ campaign_month }/montChangeStatus/0`, [], function( resp ) {

                    $('.btnCloseModal').click();

                    Swal.fire({
                        position: 'center-center',
                        text: `${ resp.message }`,
                        icon: `${ resp.status }`,
                        showConfirmButton: false,
                        timer: 2000
                    })

                }, 'json')
            })


            $("body").on("click", ".openMonth", function(){
                let campaign_month = $(this).data('id');
                $.get( `${ urlToSend }/campaigns/${ campaign_month }/montChangeStatus/1`, [], function( resp ) {

                    $('.btnCloseModal').click();

                    Swal.fire({
                        position: 'center-center',
                        text: `${ resp.message }`,
                        icon: `${ resp.status }`,
                        showConfirmButton: false,
                        timer: 2000
                    })

                }, 'json')
            })

            $('#campaigns_datatable').DataTable({
                "ordering": false,
                language : {
                    url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                }
            });

        })
    </script>
@endsection
