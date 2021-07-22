<div class="row justify-content-md-center">
    <div class="col-lg-6" style="max-width: 500px">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="bmd-label-floating">Titulo</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $alert->title) }}" required>

                    @error('title')
                        <small class="error">{{ $message }}</small><br>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="bmd-label-floating">Descripción</label>

                    <div style="display: flex; justify-content: center;">
                        <textarea id="summernote" name="description" required>{{ old('description', $alert->description) }}</textarea>
                    </div>

                    @error('description')
                        <small class="error">{{ $message }}</small><br>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="bmd-label-floating">Inicio</label><br>
                    <input type="date" name="start_at"
                           class="form-control"
                           value="{{ old('start_at', is_null($alert->start_at) ? '' : $alert->start_at->format('Y-m-d')) }}"
                           required
                           min="{{ now()->format('Y-m-d') }}"
                    >
                    @error('start_at')
                        <small class="error">{{ $message }}</small><br>
                    @enderror
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label class="bmd-label-floating">Fin</label><br>
                    <input type="date"
                           name="end_at"
                           class="form-control"
                           value="{{ old('end_at', is_null($alert->end_at) ? '' : $alert->end_at->format('Y-m-d') ) }}"
                    >
                    @error('end_at')
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
