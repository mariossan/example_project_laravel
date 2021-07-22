@extends('layouts.admin.main')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header card-header-info">
                    <h3 class="card-title">Bienvenido - {{ Auth::user()->name }} </h3>
                    {{-- {!! json_encode(auth::user()) !!} --}}
                </div>
                <div class="card-body">
                    <br><br>
                    <div class="row justify-content-md-center">
                        <div class="col-sm-8">
                            <img src="https://cdn0.iconfinder.com/data/icons/customicondesignoffice5/256/examples.png" alt="" width="100%">
                        </div>
                    </div>
                    <br><br>
                </div>
            </div>
        </div>
    </div>
@endsection
