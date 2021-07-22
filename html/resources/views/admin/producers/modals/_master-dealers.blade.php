<!-- Modal ADVERTISERS -->
<div class="modal fade" id="dealers" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Proveedores</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table secondDash">
                    <thead class="thead-info">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">dealer_code</th>
                            <th scope="col">business_name</th>
                            <th scope="col">CifDni</th>
                            <th scope="col">contable_code</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dealers as $dealerItem)
                            <tr>
                                <td>{{ $dealerItem->id }}</td>
                                <td>{{ $dealerItem->dealer_code }}</td>
                                <td>{{ $dealerItem->business_name }}</td>
                                <td>{{ $dealerItem->CifDni }}</td>
                                <td>{{ $dealerItem->contable_code }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10">
                                    Sin datos para mostrar
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
