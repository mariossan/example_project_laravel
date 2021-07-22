@extends('layouts.admin.main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info">
                        <h4 class="card-title ">Anunciantes</h4>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-4">
                                <a class="btn btn-primary" href="{{ route('advertisers.create') }}">
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
                        <div class="row justify-content-md-center">
                            <div class="col-md-6">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class=" text-primary">
                                            <tr>
                                                <th>Nombre</th>
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
            *
            *      SEARCH SECTION
            *
            */
            var dataToTable     = {!! json_encode($advertisers) !!};
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
                        let name     = simpleData['name'].toUpperCase();
                        if ( name.includes(filtro) ) {
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
                                            <td>${ dataItem.name }</td>
                                            <td align="right">

                                                <a href="${ urlToSend }/advertisers/${ dataItem.id }/edit" class="btn btn-sm btn-outline-success">
                                                    <span class="material-icons">edit</span>
                                                </a>

                                                <a href="${ urlToSend }/advertisers/${ dataItem.id }/delete" data-user='user${ dataItem.id }' class="btn btn-sm btn-outline-danger delItem" data-name='${ dataItem.name }'> <span class="material-icons">delete</span>
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

        })
    </script>
@endsection
