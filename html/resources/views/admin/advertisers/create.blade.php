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

                        <a class="btn btn-primary" href="{{ route('advertisers.index') }}">
                            <span class="material-icons">keyboard_arrow_left</span>
                            Regresar
                        </a>

                        <form action="{{ route('advertisers.store') }}" method="POST">
                            @csrf
                            @include('admin.advertisers._form', ['btn' => 'crear'])
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
