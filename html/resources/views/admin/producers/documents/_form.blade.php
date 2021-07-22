@csrf

                            <div class="row">
                                <div class="col">
                                    <div class="form-group" align="center">
                                        <label class="btn btn-info" for="uploadFile">Seleccione archivo</label>
                                        <input type="file" class="form-control" id="uploadFile" accept="application/pdf,.csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" name="pdfile" @if( !$document->id )required @endif>

                                        @error('pdfile')
                                            <small class="error">{{ $message }}</small><br>
                                        @enderror
                                        <br>

                                        <small class="success" @if( $document->name ) style='display:block' @endif>
                                            @if( $document->name )
                                                {{ $document->name }}.pdf
                                            @endif
                                        </small>
                                        <br>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group bmd-form-group">
                                        <div style="margin-bottom: 40px"></div>
                                        <label class="bmd-label-floating">Nombre</label>
                                        <input type="text" class="form-control" name='name' required value="{{ old('name', $document->name) }}">

                                        @error('name')
                                            <small class="error">{{ $message }}</small><br>
                                        @enderror

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Descripción del documento</label>
                                        <textarea id="summernote" name="description">
                                            {{ $document->description }}
                                        </textarea>

                                        @error('description')
                                            <small class="error">{{ $message }}</small><br>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div align='center'>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <div class="clearfix"></div>
                            </div>
