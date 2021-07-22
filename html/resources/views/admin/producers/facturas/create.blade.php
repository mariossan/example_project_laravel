@extends('layouts.admin.main')

@section('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
                    <h3 class="titleCampaign">{{ $campaign->name }} - Agregar factura</h3>
                </div>

                <div class="row">
                    <div class="col" align='left'>
                        <a href="{{ route("producers.facturas", $campaign) }}" class="btn btn-light">
                            Regresar <span class="material-icons">arrow_back</span>
                        </a>
                    </div>
                </div>

                <hr>

                <div class="row justify-content-md-center">

                    <div class="col-xl-10">
                        <form action="{{ route('producers.facturas-save-info', $campaign) }}" method="POST" id="docForm" enctype="multipart/form-data">
                            @csrf
                            @include("admin.producers.facturas._form", [
                                'btn'       => 'enviar',
                                'campaign'  => $campaign
                            ])
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script src="{{ asset('/js/utilities.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        var url                 = "{{ route("producers.facturas", $campaign) }}";
        var campaign            = {!! json_encode( $campaign ) !!};
        var csrf                = "{{ csrf_token() }}";
        var gastos_asociados    = [];
    </script>
    <script src="{{ asset('/js/campaigns/facturas/index.js') }}?{{ date('YmdHis') }}"></script>

@endsection
