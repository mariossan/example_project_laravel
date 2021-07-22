<div class="row justify-content-md-center">
    <div class="col-lg-12" style="">

        <div class="row">
            <div class="col-lg-3">
                <div class="form-group" align="center">
                    <div style="margin-bottom: 30px" class="selectFile"></div>
                    <label class="btn btn-info" for="uploadFile">Seleccione archivo</label>
                    <input type="file" class="form-control" id="uploadFile" accept="application/pdf" name="pdfile" @if( !$bill->id )required @endif>
                    <br>
                    @error('pdfile')
                        <small class="error">{{ $message }}</small><br>
                    @enderror
                    <small class="success" @if( $bill->file ) style='display:block' @endif>
                        @if( $bill->file )
                            {{ $bill->file }}
                        @endif
                    </small>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="form-group">
                    <div style="margin-bottom: 40px"></div>
                    <label class="bmd-label-floating">No. de Factura</label>
                    <input type="text" class="form-control" name="no_factura" value="{{ old('no_factura', $bill->no_factura) }}">
                    @error('no_factura')
                        <small class="error">{{ $message }}</small><br>
                    @enderror
                </div>
            </div>

            <div class="col-lg-3">
                <div class="form-group">
                    <div style="margin-bottom: 40px"></div>
                    <label class="bmd-label-floating">Importe Bruto</label>
                    <input type="text" class="form-control soloNumeros importe_bruto" name="importe_bruto" value="{{ old('importe_bruto', formatNumberEUIpt($bill->importe_bruto)) }}">
                    @error('importe_bruto')
                        <small class="error">{{ $message }}</small><br>
                    @enderror
                </div>
            </div>

            <div class="col-lg-3">
                <div class="form-group">
                    <div style="margin-bottom: 40px"></div>
                    <label class="bmd-label-floating">Importe Neto</label>
                    <input type="text" class="form-control soloNumeros" name="importe_neto" value="{{ old('importe_neto', formatNumberEUIpt($bill->importe_neto)) }}">
                    @error('importe_neto')
                        <small class="error">{{ $message }}</small><br>
                    @enderror
                </div>
            </div>
        </div>

        <br>

        <div class="row justify-content-md-center">
            @php
                $condiciones_pago_arr = [0,5,10,30,45,60,90];
            @endphp
            <div class="col-lg-3">
                <div>
                    <label>Condiciones de Pago</label>
                    <select class="selectpicker form-control" data-live-search="true" name="condiciones_pago" required>
                        <option value="">Seleccione</option>
                        @foreach ($condiciones_pago_arr as $cond_pago_item)
                            <option value="{{ $cond_pago_item }}" @if( $bill->condiciones_pago == $cond_pago_item ) selected @endif>{{ $cond_pago_item }} días</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-lg-3">
                <div>
                    <label>Proveedor</label>
                    <select class="selectpicker form-control" data-live-search="true" name="dealer_id" required>
                        <option value="">Seleccione</option>
                        @foreach ($dealers as $dealer)
                            <option value="{{ $dealer->id }}" @if( $bill->dealer_id == $dealer->id ) selected @endif>
                                {{ $dealer->full_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('dealer_id')
                        <small class="error">{{ $message }}</small><br>
                    @enderror
                </div>
            </div>

            <div class="col-lg-3">
                <div>
                    <label>Mes</label>
                    <select class="selectpicker form-control selectMes" data-live-search="true" name="mes" required>
                        @if( !$bill->id )
                            <option value="">Seleccione</option>
                        @endif
                        @foreach ($campaign->months as $month)
                            <option value="{{ $month->id }}" @if( $bill->campaign_month_id == $month->id ) selected @endif>{{ $month->mes }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <br>

        <div class="row justify-content-md-center">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="okpago" @if( $bill->ok_pago ) checked='checked' @endif name="ok_pago">
                <label class="custom-control-label" for="okpago">OK Pago</label>
            </div>
        </div>

        <br><br>

        <div class="row">

            {{--  aqui es donde se pinta la informacion para poder ver los meses con sus gastos --}}
            <div class="contentTabs">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    @foreach ($campaign->months as $key => $month)
                        <li class="nav-item">
                            <a class="nav-link @if( $key == 0 ) active @endif" id="mes{{ $month->id }}-tab" data-toggle="tab" href="#mes{{ $month->id }}" role="tab" aria-controls="mes{{ $month->id }}" aria-selected="true" data-id="{{ $month->id }}">{{ $month->mes }}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content" id="myTabContent">

                    @foreach ($campaign->months as $key => $month)
                        <div class="tab-pane fade show @if( $key == 0 ) active @endif" id="mes{{ $month->id }}" role="tabpanel" aria-labelledby="home-tab">
                            @include('admin.producers.facturas._data-to-print', [
                                'month'     => $month,
                                'gastos'    => $month->gastos ])
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <br>

        <div align='center'>
            <button type="submit" class="btn btn-primary">{{ $btn }}</button>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
