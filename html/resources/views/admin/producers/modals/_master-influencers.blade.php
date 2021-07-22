<!-- Modal ADVERTISERS -->
<div class="modal fade" id="influencers" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Influencers</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table secondDash">
                    <thead class="thead-info">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">Nickname</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($influencers as $influencerItem)
                            <tr>
                                <td>{{ $influencerItem->id }}</td>
                                <td>{{ $influencerItem->name }}</td>
                                <td>{{ $influencerItem->lastname }}</td>
                                <td>{{ $influencerItem->nickname }}</td>
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
