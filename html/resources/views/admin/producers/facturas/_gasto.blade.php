<tr align="center">
    <td>
        <div class="custom-control custom-checkbox">
            <input
                type='checkbox'
                name='gastos[]'
                value="{{ $gasto->id }}"
                id='gasto{{ $gasto->id }}'
                class="custom-control-input checkboxGastos"
                data-gasto="{{ $gasto->gasto }}"
                @if( in_array( $gasto->id,$gastos_asociados ) ) checked @endif
            />
            <label class="custom-control-label" for="gasto{{ $gasto->id }}">seleccionar</label>
        </div>
    </td>
    <td>{{ $gasto->talent->name }}</td>
    <td>{{ ( isset($gasto->dealer->business_name) )? $gasto->dealer->business_name : "" }}</td>
    <td>{{ ( isset($gasto->influencer->nickname) )? $gasto->influencer->nickname : "" }}</td>
    <td>{{ $gasto->concepto }}</td>
    <td>{{ $gasto->comentarios }}</td>
    {{--  <td></td>  --}}
    <td align="right">{{ formatNumberEU( $gasto->gasto ) }} €</td>
</tr>
