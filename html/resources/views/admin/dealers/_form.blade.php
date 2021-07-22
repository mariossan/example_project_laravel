<div class="row justify-content-md-center">
    <div class="col-lg-8" style="max-width: 800px">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="bmd-label-floating">Nombre Comercial</label>
                    <input type="text" name="dealer_code" class="form-control" value="{{ old('dealer_code', $dealer->dealer_code) }}" required>

                    @error('dealer_code')
                        <small class="error">{{ $message }}</small><br>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="bmd-label-floating">Razón Social</label>
                    <input type="text" name="business_name" class="form-control" value="{{ old('business_name', $dealer->business_name) }}" required>

                    @error('business_name')
                        <small class="error">{{ $message }}</small><br>
                    @enderror
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label class="bmd-label-floating">CifDni</label>
                    <input type="text" name="CifDni" class="form-control" value="{{ old('CifDni', $dealer->CifDni) }}" required>

                    @error('CifDni')
                        <small class="error">{{ $message }}</small><br>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="bmd-label-floating">Código Contable</label>
                    <input type="text" name="contable_code" class="form-control soloNumeros" value="{{ old('contable_code', $dealer->contable_code) }}" required>

                    @error('contable_code')
                        <small class="error">{{ $message }}</small><br>
                    @enderror
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label class="bmd-label-floating">¿Es Inter Company?</label>
                    <input
                        type="checkbox"
                        name="is_inter_company"
                        class="form-check-inline"
                        {{ $dealer->is_inter_company ? 'checked' : '' }}
                    >

                    @error('is_inter_company')
                    <br><small class="error">{{ $message }}</small><br>
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
