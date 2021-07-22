@extends('layouts.admin.main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info">
                        <h4 class="card-title ">Usuarios</h4>
                    </div>
                    <div class="card-body">

                        <a class="btn btn-primary" href="{{ route('users.create') }}">
                            Agregar
                            <span class="material-icons">assignment_ind</span>
                        </a>

                        <div class="table-responsive">
                            <table class="table">
                                <thead class=" text-primary">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>E-mail</th>
                                        <th>Rol</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                        <tr class="user{{ $user->id }}">
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ (isset($user->role->name)) ? $user->role->name : "" }}</td>
                                            <td class="text-primary">
                                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-success">
                                                    <span class="material-icons">edit</span>
                                                </a>

                                                <a href="{{ route('users.reSendPassword', $user) }}" class="btn btn-sm btn-outline-info">
                                                    <span class="material-icons">vpn_key</span>
                                                </a>

                                                <a href="{{ route('users.changeStatus', $user) }}" class="btn btn-sm @if( $user->status == 1 )btn-success @else btn-dark @endif btn-status">
                                                    <span class="material-icons">
                                                        @if( $user->status == 1 )cloud_queue @else cloud_off @endif
                                                    </span>
                                                </a>

                                                <a href="{{ route('users.destroy', $user) }}" data-user='user{{ $user->id }}' class="btn btn-sm btn-outline-danger delUser" data-name="{{ $user->name }}">
                                                    <span class="material-icons">delete</span>
                                                    @csrf
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10">
                                                <h3>Sin usuarios a mostrar</h3>
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
            $(".delUser").on("click", function(event){

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
                        // se hace la llamada de eliminacion
                        let urlToSend   = $(thisButton).attr('href');
                        let dataToSend  = {
                            '_method': 'delete',
                            "_token": "{{ csrf_token() }}",
                        }

                        $.post( urlToSend, dataToSend, function(response) {

                            // se hace efecto de eliminacion de usuario
                            let user = $(thisButton).data('user');

                            $(`.${ user }`).fadeOut("slow")

                            Swal.fire({
                                position: 'top-end',
                                text: `${ response.message }`,
                                icon: `${ response.status }`,
                                showConfirmButton: false,
                                timer: 2000
                            })
                        } )
                    }

                })
            })
        })
    </script>
@endsection
