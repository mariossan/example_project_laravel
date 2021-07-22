<div class="row justify-content-md-center">
    <h2 class="titleCampaign">
        @if( $campaign->image->url )
            <img style="width: 80px; height: 80px;" src="{{ asset($campaign->image->url) }}" class="card-img-top" alt="{{ $campaign->name }}">
        @endif
        {{ $campaign->name }} - {{ $section }}
    </h2>
</div>
