<div class="row justify-content-md-center">
    <div class="col-lg-6" style="max-width: 500px">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="bmd-label-floating">Nombre</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>

                    @error('name')
                        <small class="error">{{ $message }}</small><br>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="bmd-label-floating">E-mail</label>

                    @if (  $btn == 'crear')
                        <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>

                        @error('email')
                            <small class="error">{{ $message }}</small><br>
                        @enderror
                    @else
                    <input type="email" class="form-control" value="{{ old('email', $user->email) }}" required disabled readonly>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-7">
                <div class="form-group">
                    <label class="bmd-label-floating">Contraseña</label>
                    <input type="password" class="form-control passwd" name="password" autocomplete="off" value="{{ old('password') }}">

                    @error('password')
                        <small class="error">{{ $message }}</small><br>
                    @enderror
                </div>
            </div>
            <div class="col-2">
                <a href="#" class="btn btn-default btn-sm btnSeePass inactive" style="margin-top: 1rem;">
                    <span class="material-icons">visibility</span>
                </a>
            </div>

            <div class="col-3">
                <a href="#" class="btn btn-info btn-sm btnGeneratePass" style="margin-top: 1rem;">Generar</a>
            </div>
        </div>
        <div class="row">
            <div class="col">

                <div class="form-group">
                    <select class="browser-default custom-select" name="role_id" required>
                        <option value="0">Rol</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" @if($user->role_id == $role->id) selected @endif>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                @error('role_id')
                    <small class="error">{{ $message }}</small><br>
                @enderror

            </div>
        </div>
        <div class="clearfix"></div>
        <br>

        <div align='center'>
            <button type="submit" class="btn btn-primary">{{ $btn }}</button>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

@section('js')
    <script>
        $(function(){

            $('.btnSeePass').on('click', function(){
                if ( $(this).hasClass('inactive') ) {
                    $(this).html(`<span class="material-icons">visibility_off</span>`);

                    $(this).removeClass('inactive')
                    $('.passwd').attr('type', 'text')

                } else {
                    $(this).html(`<span class="material-icons">visibility</span>`);
                    $(this).addClass('inactive')
                    $('.passwd').attr('type', 'password')

                }
            })

            $('.btnGeneratePass').on('click', function() {
                let pass = Math.random().toString(36).substring(2, 15) + specialChars() +  Math.random().toString(36).substring(2, 15) + specialChars()
                $('.passwd').val(pass)
            })

            var specialChars = () => {
                let chars = [',', '.', '_', '#', '$', '@', '!', '=', '+', '-']
                return chars[Math.floor(Math.random() * 10)]
            }
        })
    </script>
@endsection
