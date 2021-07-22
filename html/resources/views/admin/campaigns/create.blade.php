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

                        <a class="btn btn-primary" href="{{ route('campaigns.index') }}">
                            <span class="material-icons">keyboard_arrow_left</span>
                            Regresar
                        </a>

                        <form action="{{ route('campaigns.store') }}" method="POST" id="formCampaign">
                            @csrf
                            @include('admin.campaigns._form', ['btn' => 'crear'])
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
