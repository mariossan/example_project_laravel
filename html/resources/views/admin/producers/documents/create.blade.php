@extends('layouts.admin.main')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-info">
                <h3 class="card-title">Bienvenido - {{ Auth::user()->name }} </h3>
                {{-- {!! json_encode(auth::user()) !!} --}}
            </div>
            <div class="card-body dashboard">
                <div class="row justify-content-md-center">
                    <h2 class="titleCampaign">{{ $campaign->name }} - Agregar Documentación</h2>
                </div>

                <div class="row">
                    <div class="col" align='left'>
                        <a href="{{ route("producers.documentacion", $campaign) }}" class="btn btn-light">
                            Regresar <span class="material-icons">arrow_back</span>
                        </a>
                    </div>
                </div>

                <hr>

                <div class="row justify-content-md-center">

                    <div class="col-xl-5 col-lg-8">
                        <form action="{{ route('producers.documentacion-save', $campaign) }}" method="POST" id="docForm" enctype="multipart/form-data">
                            @include('admin.producers.documents._form')
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
        var url         = "{{ route("producers.documentacion", $campaign) }}";
    </script>
    <script src="{{ asset('/js/campaigns/documentation/index.js') }}"></script>

@endsection
