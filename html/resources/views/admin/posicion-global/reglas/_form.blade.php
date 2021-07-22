<div class="row">
    <div class="col-lg-3">
        <div class="form-group">
            <div style="margin-bottom: 40px"></div>
            <label class="bmd-label-floating">Nombre regla</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $rule->name) }}" required>
        </div>
    </div>

    <div class="col-lg-3">
        <div>
            <label>Proveedor</label>
            <select class="selectpicker form-control" data-live-search="true" name="dealer_id" required>
                <option value="">Seleccione</option>
                @foreach ($dealers as $dealer)
                    <option value="{{ $dealer->id }}" @if( $dealer->id == $rule->dealer_id ) selected @endif>
                        {{ $dealer->business_name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-lg-3">
        <div>
            <label>Tipos</label>
            <select class="selectpicker form-control" multiple data-live-search="true" name="ids_tipos[]" required>
                <option value="">Seleccione</option>
                @foreach ($tipos as $tipoItem)
                    <option value="{{ $tipoItem->id }}"
                        @if( is_array( $rule->ids_tipos ) )
                            @if( in_array($tipoItem->id, $rule->ids_tipos) )
                                selected
                            @endif
                        @endif
                    >
                        {{ $tipoItem->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="form-group">
            <div style="margin-bottom: 40px"></div>
            <label class="bmd-label-floating">Acuerdo %</label>
            <input type="text" name="acuerdo" class="form-control soloNumeros" value="{{ old('acuerdo', $rule->acuerdo) }}" required>
        </div>
    </div>
</div>

<div align='center'>
    <button type="submit" class="btn btn-info">{{ $btn }}</button>
</div>
