@extends('layouts.admin.main')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-info">
                        <h4 class="card-title ">Alerta</h4>
                    </div>
                    <div class="card-body">

                        <a class="btn btn-primary" href="{{ route('influencers.alerts',$influencer) }}">
                            <span class="material-icons">keyboard_arrow_left</span>
                            Regresar
                        </a>

                        <form action="{{ route('alerts.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="influencer_id" value="{{ $influencer->id }}">
                            @include('admin.influencers._alert_form', ['btn' => 'Crear'])
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <script>
        $(function() {
            $('#summernote').summernote({
                width: "90%",
                height: 100,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                ]
            });
        });
    </script>

@endsection
