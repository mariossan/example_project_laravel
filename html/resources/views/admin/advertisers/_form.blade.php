<div class="row justify-content-md-center">
    <div class="col-lg-6" style="max-width: 500px">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="bmd-label-floating">Nombre</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $advertiser->name) }}" required>

                    @error('name')
                        <small class="error">{{ $message }}</small><br>
                    @enderror
                </div>
            </div>
        </div>


        <div align='center'>
            <button type="submit" class="btn btn-primary">{{ $btn }}</button>
            <div class="clearfix"></div>
        </div>
    </div>
</div>