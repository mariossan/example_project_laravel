
<div class="modal fade" id="clients" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Clientes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table secondDash">
                    <thead class="thead-info">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Código de cliente</th>
                            <th scope="col">Razón Social</th>
                            <th scope="col">Nombre Fiscal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clients as $clientItem)
                            <tr>
                                <td>{{ $clientItem->id }}</td>
                                <td>{{ $clientItem->client_code }}</td>
                                <td>{{ $clientItem->business_name }}</td>
                                <td>{{ $clientItem->fiscal_name }}</td>
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
