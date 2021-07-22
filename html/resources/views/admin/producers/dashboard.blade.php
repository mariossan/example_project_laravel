@extends('layouts.admin.main')

@section('content')

    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-info">
                <h3 class="card-title">Bienvenido - {{ Auth::user()->name }} </h3>
                {{-- {!! json_encode(auth::user()) !!} --}}
            </div>
            <div class="card-body">
                <br><br>
                <div class="row justify-content-md-center">
                    <div class="col-lg-10 col-md-10">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist" style="justify-content: center">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true"><i class="material-icons">api</i> Campañas</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">
                                    <span class="material-icons">bookmarks</span> Maestros
                                </a>
                            </li>
                        </ul>
                        <br>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                {{-- Se muestran las campa;as asignadas --}}

                                <table class="table table-sm secondDash" id="producers_table">
                                    <thead class="text-info">
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Campaña</th>
                                            <th scope="col">Fecha de creación</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    @forelse ($campaigns as $campaignItem)
                                        <tr>
                                            <td>{{ $campaignItem->id }}</td>
                                            <td>{{ $campaignItem->name }}</td>
                                            <td>{{ $campaignItem->created_at }}</td>
                                            <td align="right">
                                                <a href="{{ route("producers.resumen", $campaignItem) }}" class="btn btn-primary btn-sm">
                                                    <i class="far fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10">
                                                Sin informacion para mostrar
                                            </td>
                                        </tr>
                                    @endforelse
                                </table>
                            </div>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                {{-- Se muestran los catalogos de los --}}
                                <div class="row justify-content-md-center">
                                    <div class="col-lg-6 masters">
                                        <button class="btn btn-outline-info" data-toggle="modal" data-target="#advertisers">
                                            <i class="material-icons">group_work</i> Anunciantes
                                        </button>

                                        <button class="btn btn-outline-info" data-toggle="modal" data-target="#clients">
                                            <i class="material-icons">group</i> Clientes
                                        </button>

                                        <button class="btn btn-outline-info" data-toggle="modal" data-target="#influencers">
                                            <i class="material-icons">movie_filter</i> Influencers
                                        </button>

                                        <button class="btn btn-outline-info" data-toggle="modal" data-target="#dealers">
                                            <i class="material-icons">assignment_ind</i> Proveedores
                                        </button>
                                    </div>
                                </div>

                                @include('admin.producers.modals._master-advertisers')
                                @include('admin.producers.modals._master-clients')
                                @include('admin.producers.modals._master-influencers')
                                @include('admin.producers.modals._master-dealers')


                            </div>
                        </div>
                    </div>
                </div>

                <br><br>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(function() {
            $('#producers_table').DataTable({
                "ordering": false,
                language : {
                    url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                }
            });
        })
    </script>
@endsection
