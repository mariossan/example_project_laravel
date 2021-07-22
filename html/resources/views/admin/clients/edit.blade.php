@extends('layouts.admin.main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info">
                        <h4 class="card-title ">Clientes</h4>
                    </div>
                    <div class="card-body">

                        <a class="btn btn-primary" href="{{ route('clients.index') }}">
                            <span class="material-icons">keyboard_arrow_left</span>
                            Regresar
                        </a>

                        <form action="{{ route('clients.update', $client) }}" method="POST">
                            @csrf
                            @method('patch')
                            @include('admin.clients._form', ['btn' => 'actualizar'])
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
