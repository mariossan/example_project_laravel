<tr align="center">
    {{-- <td>{{ $month->mes }}</td> --}}
    <td>{{ $gasto->talent->name }}</td>
    <td>{{ ( isset($gasto->dealer->business_name) )? $gasto->dealer->business_name : "" }}</td>
    <td>
        <ul>
            @forelse($gasto->getInfluencers() as $influencer)
                <li>
                    {{ $influencer->full_name }}
                </li>
            @empty
                N/A
            @endforelse
        </ul>
    </td>
    <td>{{ $gasto->concepto }}</td>
    <td>{{ $gasto->comentarios }}</td>
    {{--  <td></td>  --}}
    <!--td align="right">{{ formatNumberEU( $month->presupuesto - $auxGastoTotal ) }} €</td-->
    <td align="center">{{ formatNumberEU( $gasto->gasto ) }} €</td>
    <td> {{ $gasto->user->name }} </td>


    <!--td align="right">{{ formatNumberEU( $month->presupuesto - $gastoTotal ) }} €</td>
    <td>{{ formatNumberEU( ($gasto->gasto * 100) / $month->presupuesto ) }} %</td-->
    <td>
        @if( ( auth()->user()->id == $gasto->user_id && $month->status == 1 ) || auth()->user()->hasRoles(['Administrador']) )
            <a href="{{ route('producers.gastos-edit', [$campaign, $gasto]) }}" class="btn btn-outline-dark btn-sm">
                <span class="material-icons">mode_edit_outline</span>
                <div class="ripple-container"></div>
            </a>

            <form action="{{ route('producers.gastos-destroy', [$gasto]) }}"
                  method="POST"
                  style="display: inline-block;"
            >
                @csrf
                @method('DELETE')
                <a class="btn btn-destroy btn-sm btn-danger text-white">
                    <span class="material-icons">delete</span>
                    <div class="ripple-container"></div>
                </a>
            </form>
        @endif
    </td>
</tr>
