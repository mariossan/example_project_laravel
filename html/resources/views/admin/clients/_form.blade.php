<div class="row justify-content-md-center">
    <div class="col-lg-6" style="max-width: 500px">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="bmd-label-floating">Código de Cliente</label>
                    <input type="text" name="client_code" class="form-control soloNumeros" value="{{ old('client_code', $client->client_code) }}" required>

                    @error('client_code')
                        <small class="error">{{ $message }}</small><br>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="bmd-label-floating">Razón Social</label>
                    <input type="text" name="business_name" class="form-control" value="{{ old('business_name', $client->business_name) }}" required>

                    @error('business_name')
                        <small class="error">{{ $message }}</small><br>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="bmd-label-floating">Nombre Fiscal</label>
                    <input type="text" name="fiscal_name" class="form-control" value="{{ old('fiscal_name', $client->fiscal_name) }}" required>

                    @error('fiscal_name')
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

@section('js')

    <script>
        $(function(){
            $('.soloNumeros').on('input propertychange',function(){
                var RegExPattern = /^\d+$/;
                $(this).val($(this).val().replace(/[[a-zA-Z\u00D1\u00F1\u00C1\u00E1\u00C9\u00E9\u00CD\u00ED\u00D3\u00F3\u00DA\u00FA\u00DC\u00FC@. ]/gi, ""));
            });
        })
    </script>
    
@endsection