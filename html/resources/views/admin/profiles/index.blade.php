@extends('layouts.admin.main')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-info">
                <h3 class="card-title">Bienvenido - {{ Auth::user()->name }} </h3>
                {{-- {!! json_encode(auth::user()) !!} --}}
            </div>
            <div class="card-body dashboard">
                <div class="row justify-content-md-center">
                    <h2 class="titleCampaign">Mi Perfil</h2>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        @include('admin.profiles._informacion-general')
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection



