<div class="row justify-content-md-center">
    <div class="col-lg-6" style="max-width: 500px">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="bmd-label-floating">Nombre</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $influencer->name) }}" required>

                    @error('name')
                        <small class="error">{{ $message }}</small><br>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="bmd-label-floating">Apellido</label>
                    <input type="text" name="lastname" class="form-control" value="{{ old('lastname', $influencer->lastname) }}" required>

                    @error('lastname')
                        <small class="error">{{ $message }}</small><br>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="bmd-label-floating">Nickname</label>
                    <input type="text" name="nickname" class="form-control" value="{{ old('nickname', $influencer->nickname) }}" required>

                    @error('nickname')
                        <small class="error">{{ $message }}</small><br>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="bmd-label-floating">Agencia</label>
                    <input type="text" name="agencia" class="form-control" value="{{ old('agencia', $influencer->agencia) }}">

                    @error('agencia')
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
