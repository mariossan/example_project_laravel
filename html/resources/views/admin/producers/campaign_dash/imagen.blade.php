<div class="col-xl-4 col-md-12">
    <div class="card">
        <div class="card-header card-header-text card-header-primary">
            <div class="card-text">
                <h4 class="card-title">Actualizar imagen</h4>
            </div>
        </div>
        <div class="card-body text-center">
            <div class="card justify-content-center">
                @error('image')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
                @if( $campaign->image->url )
                    <img style="width: 200px; height: 200px;margin-left: auto;margin-right: auto;" id="preview-image-after-upload" src="{{ asset($campaign->image->url) }}" class="card-img-top mt-5" alt="{{ $campaign->name }}">
                @endif
                <img id="preview-image-before-upload" class="card-img-top mt-5" alt="{{ $campaign->name }}" style="display: none; width: 200px; height: 200px;margin-left: auto;margin-right: auto;">
                <div class="card-body">
                    @if( !$campaign->image->url )
                        <p class="card-text">
                            No hay imagen
                        </p>
                    @endif
                    <form action="{{ route('producers.update-image', $campaign) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        <div class="form-group">
                            <label for="image">Click para seleccionar foto</label>
                            <input type="file" class="form-control-file" name="image" id="image" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Actualizar imagen</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
