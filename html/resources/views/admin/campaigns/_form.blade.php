@section('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection

<div class="row justify-content-md-center">
    <div class="col-lg-10" style="">
        <div class="row">
            <div class="col-lg-4">
                <div>
                    <label>Cliente</label>
                    <select class="selectpicker form-control client_id" data-live-search="true" name="client_id" required>
                        <option value="">Seleccione</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}" @if($campaign->client_id == $client->id) selected @endif>{{ $client->business_name }}</option>
                        @endforeach
                    </select>

                    @error('client_id')
                        <small class="error">{{ $message }}</small><br>
                    @enderror
                </div>

            </div>

            <div class="col-lg-4">
                <div class="form-group">
                    <div style="margin-bottom: 40px"></div>
                    <label class="bmd-label-floating">Agencia</label>
                    <input type="text" name="agencia" class="form-control" value="{{ old('agencia', $campaign->agencia) }}" required>
                    @error('agencia')
                        <small class="error">{{ $message }}</small><br>
                    @enderror
                </div>
            </div>

            <div class="col-lg-4">
                <div>
                    <label>Anunciantes</label>
                    <select class="selectpicker form-control advertiser_id" data-live-search="true" name="advertiser_id" required>
                        <option value="">Seleccione</option>
                        @foreach ($advertisers as $advertiser)
                            <option value="{{ $advertiser->id }}" @if($campaign->advertiser_id == $advertiser->id) selected @endif>{{ $advertiser->name }}</option>
                        @endforeach
                    </select>

                    @error('advertiser_id')
                        <small class="error">{{ $message }}</small><br>
                    @enderror
                </div>
            </div>
        </div>

        <br>


        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="bmd-label-floating">Campaña</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $campaign->name) }}" required>

                    @error('name')
                        <small class="error">{{ $message }}</small><br>
                    @enderror
                </div>
            </div>

            <div class="col-lg-4">
                <div class="form-group">
                    <label class="bmd-label-floating">Mes de Inicio</label>
                    <input type="text" name="month_start" class="form-control from" value="{{ old('month_start', $campaign->month_start) }}" required @if( $btn == 'actualizar' ) disabled @endif>

                    @error('month_start')
                        <small class="error">{{ $message }}</small><br>
                    @enderror
                </div>
            </div>

            <div class="col-lg-4">
                <div class="form-group">
                    <label class="bmd-label-floating">Mes de Fin</label>
                    <input type="text" name="month_end" class="form-control to" value="{{ old('month_end', $campaign->month_end) }}" required @if( $btn == 'actualizar' ) disabled @endif>

                    @error('month_end')
                        <small class="error">{{ $message }}</small><br>
                    @enderror
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <div style="margin-bottom: 40px"></div>
                    <label class="bmd-label-floating">Total de Meses</label>
                    <input type="text" name="total_months" class="form-control totalMonths" value="{{ old('total_months', $campaign->total_months) }}" required readonly>

                    @error('total_months')
                        <small class="error">{{ $message }}</small><br>
                    @enderror
                </div>
            </div>

            {{--  <div class="col-lg-4">
                <div class="form-group">
                    <div style="margin-bottom: 40px"></div>
                    <label class="bmd-label-floating">Extraprima Agencia (%)</label>
                    <input type="text" name="extraprima_agencia" class="form-control" value="{{ old('extraprima_agencia', $campaign->extraprima_agencia) }}" required>

                    @error('extraprima_agencia')
                        <small class="error">{{ $message }}</small><br>
                    @enderror
                </div>
            </div>  --}}

            <div class="col-lg-4">
                <div>
                    <label>Producers</label>
                    <select class="selectpicker form-control" multiple data-live-search="true" name="user_id[]" required>
                        @foreach ($producers as $producer)
                            @if( isset( $campaign['producers_id'] ) )
                                <option value="{{ $producer->id }}" @if( in_array( $producer->id, $campaign['producers_id']) == true ) selected @endif>{{ $producer->name }}</option>
                            @else
                                <option value="{{ $producer->id }}">{{ $producer->name }}</option>
                            @endif
                        @endforeach
                    </select>

                    @error('user_id')
                        <small class="error">{{ $message }}</small><br>
                    @enderror
                </div>
            </div>
        </div>

        <br><hr><br>

        <section class="months">
            <div class="row justify-content-md-center">

                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="bmd-label-floating">Ingresos (€)</label>
                        <input type="text" name="ingresos" class="form-control ingresosIpt soloNumeros" value="{{ old('ingresos', formatNumberEUIpt($campaign->ingresos)) }}" required>

                        @error('ingresos')
                            <small class="error">{{ $message }}</small><br>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="bmd-label-floating">Presupuesto (€)</label>
                        <input type="text" name="ppto_gastos" class="form-control presupuestoIpt soloNumeros" value="{{ old('ppto_gastos', formatNumberEUIpt($campaign->ppto_gastos)) }}">

                        @error('ppto_gastos')
                            <small class="error">{{ $message }}</small><br>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="bmd-label-floating">Margen %</label>
                        <input type="text" name="margen" class="form-control margenIpt soloNumeros" value="{{ old('margen', $campaign->margen) }}">

                        @error('margen')
                            <small class="error">{{ $message }}</small><br>
                        @enderror
                    </div>
                </div>

            </div>

            <div align='center'>
                @if( !isset( $campaign->id) )
                    <a class="btn btn-info btnShowTable" style="color: #fff">Mostrar Tabla</a>
                @endif
            </div>

            <br><hr><br>

            <div class="row justify-content-md-center">
                <div class="col-lg-8 toPrintMonths" style="@if( !isset( $campaign->id ) ) display: none @endif">
                    @if( isset( $campaign->id ) )
                        {{-- se hace pintado de la tabla que ya se habia prellenado --}}
                        <div class="row">
                            <div class="col">Mes</div>
                            <div class="col">Ingresos</div>
                            <div class="col">Presupuesto</div>
                        </div>

                        @foreach ($campaign->months as $month)
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <input type="text" name="mes[]" class="form-control" value="{{ $month->mes }}" readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <input type="text" name="ingresosMes[]" class="form-control ingresoData soloNumeros" value="{{ $month->ingreso }}" placeholder="Ingreso €" required @if( $month->status == 0 ) readonly  @endif>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <input type="text" name="presupuestosMes[]" class="form-control presupuestoData soloNumeros" value="{{ $month->presupuesto }}" placeholder="Presupuesto €" required @if( $month->status == 0 ) readonly  @endif>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    @endif
                </div>
            </div>

            @if( isset( $campaign->id ) )
                <div align='center'>
                    <a class="btn btn-sm btn-success btnAddMonth" href="#" data-toggle="modal" data-target="#exampleModal">
                        mes <span class="material-icons">add_circle</span>
                    </a>
                </div>
            @endif
        </section>

        <hr>


        <div align='center'>
            <button type="submit" class="btn btn-primary">{{ $btn }}</button>
            {{--  <a href="#" class="btn btn-primary btnNext">{{ $btn }}</a>  --}}
            <div class="clearfix"></div>
        </div>
    </div>
</div>



@include('admin.campaigns._modal-new-month')


@section('js')

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ asset("/js/months_service.js") }}?{{ date("YmdHis") }}"></script>
    <script src="{{ asset("/js/utilities.js") }}?{{ date("YmdHis") }}"></script>

    <script>
        var dataToTable     = {!! json_encode($producers) !!};
        var urlToSend       = "{{ url('/') }}";

        @if( isset($campaign["months"]) )
            var mesesDB         = {!! json_encode($campaign["months"]) !!};
            var fecha_inicio    = "{{ $campaign->month_start }}"
            var fecha_fin       = "{{ $campaign->month_end }}"

            fecha_inicio        = getSeparatedDate( fecha_inicio );
            fecha_fin           = getSeparatedDate( fecha_fin );
        @endif
    </script>

    <script src="{{ asset('/js/campaigns/index.js') }}?{{ date("YmdHis") }}"></script>

@endsection
