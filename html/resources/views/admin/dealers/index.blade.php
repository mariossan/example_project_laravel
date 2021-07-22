@extends('layouts.admin.main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info">
                        <h4 class="card-title ">Proveedores</h4>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-4">
                                <a class="btn btn-primary" href="{{ route('dealers.create') }}">
                                    Agregar
                                    <span class="material-icons">assignment_ind</span>
                                </a>
                            </div>
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control txt-search" placeholder="Buscar" aria-label="Buscar" aria-describedby="basic-addon2" id="autocomplete">
                                    <span class="btn btn-sm btn-info" id="basic-addon2">buscar</span>
                                  </div>
                            </div>
                        </div>

                        <br><br>
                        <div class="table-responsive">
                            <table class="table">
                                <thead class=" text-primary">
                                    <tr>
                                        <th>Nombre comercial</th>
                                        <th>Razón social</th>
                                        <th>CifDni</th>
                                        <th>Codigo contable</th>
                                        <th>Es Inter Company</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="tbody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('admin.dealers._modal-alert')
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
            *
            *      SEARCH SECTION
            *
            * */
            var dataToTable     = {!! json_encode($dealers) !!};
            var urlToSend       = "{{ url('/') }}";

            /**
             * Method to filter dealers by word
             * @param object dealers
             * @param string filtro in upper case
             * @retun object dealers with filter
             * */
             let printTable  = (dataToTable, filtro = null ) => {
                let dataToPrint = dataToTable.filter(function (simpleData, index, array) {
                    if ( filtro !== null ) {
                        let dealer_code     = simpleData.dealer_code.toUpperCase();
                        let business_name   = simpleData.business_name.toUpperCase();
                        let CifDni          = simpleData.CifDni.toUpperCase();
                        let contable_code   = simpleData.contable_code.toUpperCase();

                        if ( dealer_code.includes(filtro) || business_name.includes(filtro) || CifDni.includes(filtro) || contable_code.includes(filtro) ) {
                            return true;
                        }

                    } else {

                        return true;
                    }

                    return false;
                });

                formatTable(dataToPrint);
            };


            /**
             * Method to print dealers like a table
             * @param object dealersToPrint
             * @return void
             * */
             let formatTable = ( dataToPrint ) => {

                if ( dataToPrint.length > 0 ) {

                    $('.tbody').html('');

                    for ( dataItem of dataToPrint ) {
                        let html = `<tr>
                                            <td>${ dataItem.dealer_code }</td>
                                            <td>${ dataItem.business_name }</td>
                                            <td>${ dataItem.CifDni }</td>
                                            <td>${ dataItem.contable_code }</td>
                                            <td>${ dataItem.is_inter_company ? 'Si' : 'No' }</td>
                                            <td align="right">
                                                <a href="${ urlToSend }/dealers/${ dataItem.id }/edit" class="btn btn-sm btn-outline-success">
                                                    <span class="material-icons">edit</span>
                                                </a>

                                                <a
                                                    href="#"
                                                    data-id='${ dataItem.id }'
                                                    class="btn btn-sm btn-${ (dataItem.warning != '') ? 'warning' : 'outline-dark' } alertItem alertItem${ dataItem.id }"
                                                    data-name='${ dataItem.business_name }'
                                                    data-alerta='${ dataItem.warning }'
                                                    data-toggle="modal" data-target="#warningText">
                                                        <span class="material-icons">warning_amber</span>
                                                </a>

                                                <a href="${ urlToSend }/dealers/${ dataItem.id }/delete" data-user='user${ dataItem.id }' class="btn btn-sm btn-outline-danger delItem" data-name='${ dataItem.business_name }'> <span class="material-icons">delete</span>
                                                </a>


                                            </td>
                                        </tr>`;
                        $('.tbody').append(html);
                    }

                } else {
                    $('.tbody').html(`  <tr>
                                            <td colspan='10'>
                                                <h3 align='center'>No se encontraron coincidencias</h3>
                                            </td>
                                        </tr>`);
                }
            };


            printTable(dataToTable);

            /**
             *  Method to filter dealers and information
             *
             * */
            $('#autocomplete').on('keyup', function(){
                printTable(dataToTable,  $(this).val().toUpperCase() );
            })

            /**
             * Method to del item
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
            var dealer_id = 0;
            $("body").on("click", ".alertItem", function(event){
                event.preventDefault()
                dealer_id = $(this).data('id')
                $('.dealer_id').val( dealer_id )
                $('.alertaText').val( $(this).data('alerta') ).change()
                $('.modal-body span').html( $(this).data('name') );
            })

            $('#formAlerta').on('submit', function(event){
                event.preventDefault();

                {{-- se hace la lectura de informacion para el envio por ajax --}}
                let urlToSend   = $(this).attr('action');
                let dataToSend  = $(this).serialize();
                var alerta      =  $(this).serializeArray()[1].value


                $.post( urlToSend, dataToSend, function(resp){
                    console.log(resp)
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
                        $(`.alertItem${ dealer_id }`).removeClass('btn-warning');
                        $(`.alertItem${ dealer_id }`).removeClass('btn-outline-dark');

                        if ( alerta == "" ) {
                            $(`.alertItem${ dealer_id }`).addClass('btn-outline-dark');
                        } else {
                            $(`.alertItem${ dealer_id }`).addClass('btn-warning');
                        }


                       {{-- se cambia el texto del boton igualmente para lo que usa la modal --}}
                       $(`.alertItem${ dealer_id }`).data('alerta', alerta);
                    }
                }, 'json' )

                return false;
            })


        })
    </script>
@endsection
