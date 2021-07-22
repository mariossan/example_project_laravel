<!-- Modal -->
<div class="modal fade" id="exampleModal{{ $infoItem->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-sm">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Producers</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            @foreach ($infoItem->campaign->users as $userItem)
                <p>{{ $userItem->name }}</p>
            @endforeach
        </div>
        </div>
    </div>
</div>
