<div class="row justify-content-md-center">
    <div class="col-lg-3">
        <div>
            <label class="">Mes</label>
            <select class="selectpicker form-control" data-live-search="true" name="campaign_month_id" required>
                @foreach ($months as $key => $month)
                    <option value="{{ $month->id }}"
                        @if( $gasto->campaign_month_id == $month->id ) selected @endif
                        @if( !isset( $gasto->campaign_month_id ) && $mes == $month->id ) selected @endif
                    >
                        {{ $month->mes }}
                    </option>
                @endforeach
            </select>

            @error('campaign_month_id')
                <small class="error">{{ $message }}</small><br>
            @enderror
        </div>
    </div>

    <div class="col-lg-3">
        <div>
            <label>Tipo</label>

            <select class="selectpicker form-control" data-live-search="true" name="talent_id" required>
                <option value="">Seleccione</option>
                @foreach ($talents as $talent)
                    <option value="{{ $talent->id }}" @if( $gasto->talent_id == $talent->id ) selected @endif >{{ $talent->name }}</option>
                @endforeach
            </select>

            @error('talent_id')
                <small class="error">{{ $message }}</small><br>
            @enderror
        </div>
    </div>

    <div class="col-lg-3">
        <div>
            <label>Proveedor</label>

            <select class="selectpicker form-control dealerSelect" data-live-search="true" name="dealer_id">
                <option value="">Seleccione</option>
                @foreach ($dealers as $dealer)
                    <option value="{{ $dealer->id }}" @if( $gasto->dealer_id == $dealer->id ) selected @endif>{{ $dealer->full_name }}</option>
                @endforeach
            </select>

            @error('dealer_id')
                <small class="error">{{ $message }}</small><br>
            @enderror
        </div>
    </div>

    <div class="col-lg-3">
        <div>
            <label>Talento</label>

            <select id="influencerSelect" class="selectpicker form-control influencerSelect" data-live-search="true" name="influencer_id[]" multiple>
                <option value="">Seleccione</option>
                @foreach ($influencers as $influencer)
                    <option
                        value="{{ $influencer->id }}"
                        {{ collect( $gasto->influencer_id )->contains($influencer->id) ? 'selected' : '' }}
                    >
                        {{ $influencer->name }} {{ $influencer->lastname }} - {{ $influencer->nickname }}
                    </option>
                @endforeach
            </select>

            @error('influencer_id')
            <small class="error">{{ $message }}</small><br>
            @enderror
        </div>
    </div>

    <div class="col-lg-3">
        <div class="form-group">
            <div style="margin-bottom: 40px"></div>
            <label class="bmd-label-floating">Concepto</label>
            <input type="text" class="form-control" name="concepto" value="{{ old('concepto', $gasto->concepto) }}" required>
            @error('concepto')
                <small class="error">{{ $message }}</small><br>
            @enderror
        </div>
    </div>

    <div class="col-lg-3">
        <div class="form-group">
            <div style="margin-bottom: 40px"></div>
            <label class="bmd-label-floating">Comentarios</label>
            <input type="text" class="form-control" name="comentarios" value="{{ old('comentarios', $gasto->comentarios) }}">
            @error('comentarios')
                <small class="error">{{ $message }}</small><br>
            @enderror
        </div>
    </div>

    <div class="col-lg-3">
        <div class="form-group">
            <div style="margin-bottom: 40px"></div>
            <label class="bmd-label-floating">Gasto €</label>
            <input type="text" class="form-control soloNumeros" name="gasto" required value="{{ old('gasto', formatNumberEUIpt( $gasto->gasto) ) }}">
            @error('gasto')
                <small class="error">{{ $message }}</small><br>
            @enderror
        </div>
    </div>

    {{-- <div class="col-lg-3">
        <div class="form-group">
            <div style="margin-bottom: 40px"></div>
            <label class="bmd-label-floating">Pendiente de aplicar</label>
            <input type="text" class="form-control correct" name="descripcion" disabled value="1.000,00 €">
        </div>
    </div> --}}
</div>

<br>

<div align='center'>
    <button type="submit" class="btn btn-primary">{{ $btnName }}</button>
    <div class="clearfix"></div>
</div>
