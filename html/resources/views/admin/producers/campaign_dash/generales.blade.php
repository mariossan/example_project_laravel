<div class="col-xl-6 col-md-12">
    <div class="card">
        <div class="card-header card-header-text card-header-primary">
            <div class="card-text">
                <h4 class="card-title">Generales</h4>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover firstDash">
                <tbody>
                    <tr>
                        <td>Cliente</td>
                        <td>{{ $campaign->client->business_name }}</td>
                    </tr>
                    <tr>
                        <td>Agencia</td>
                        <td>{{ $campaign->agencia }}</td>
                    </tr>

                    <tr>
                        <td>Campaña</td>
                        <td>{{ $campaign->name }}</td>
                    </tr>
                    <tr>
                        <td>Mes inicio</td>
                        <td>{{ chageDate( $campaign->month_start ) }}</td>
                    </tr>
                    <tr>
                        <td>Mes fin</td>
                        <td>{{ chageDate( $campaign->month_end ) }}</td>
                    </tr>
                    <tr>
                        <td>Total de meses</td>
                        <td>{{ $campaign->total_months }}</td>
                    </tr>
                    {{--  <tr>
                        <td>Extraprima agencia</td>
                        <td>{{ $campaign->extraprima_agencia }} %</td>
                    </tr>  --}}
                    <tr>
                        <td>Producers</td>
                        <td>
                            @foreach ($producers as $producer)
                                @if( isset( $campaign->producers_id ) )
                                    @if( in_array( $producer->id, $campaign->producers_id) == true ) {{ $producer->name }} <br> @endif
                                @endif
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
