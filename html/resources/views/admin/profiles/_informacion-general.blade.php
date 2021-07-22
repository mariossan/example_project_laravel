<div class="row">
    <div class="col-xl-6 col-md-12">
        <div class="card">
            <div class="card-header card-header-text card-header-primary">
                <div class="card-text">
                    <h4 class="card-title">Informacion General</h4>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover firstDash">
                    <tbody>
                        <tr>
                            <td>Nombre</td>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td>Correo Electronico</td>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <td>Rol</td>
                            <td>{{ $user->role->name }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-header card-header-text card-header-primary">
                <div class="card-text">
                    <h4 class="card-title">Emails</h4>
                    <h6 class="card-subtitle mb-2" style="font-weight: lighter">
                        ¿Deseas recibir las siguientes notificaciones?
                    </h6>
                </div>
            </div>
            <div class="card-body table-responsive">
                <form action="{{ route('profile.update', $user) }}" method="post">
                    <table class="table table-hover firstDash">
                        <tbody>
                            @csrf
                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                            @foreach($notifications as $notification)
                                <tr>
                                    <td>{{ $notification->name }}</td>
                                    <td>
                                        <input
                                            type="checkbox"
                                            name="notifications[]"
                                            class="form-check-inline"
                                            value="{{ $notification->id }}"
                                            {{ $user->profile->notifications->contains($notification->id) ? 'checked' : '' }}
                                        >
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-12">
        <div class="card">
            <div class="card-header card-header-text card-header-primary">
                <div class="card-text">
                    <h4 class="card-title">Actualizar foto</h4>
                </div>
            </div>
            <div class="card-body text-center">
                <div class="card justify-content-center">
                    @error('image')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                    @if( $user->profile->image->url )
                        <img style="width: 200px; height: 200px;margin-left: auto;margin-right: auto;" id="preview-image-after-upload" src="{{ asset($user->profile->image->url) }}" class="card-img-top mt-5" alt="{{ $user->name }}">
                    @endif
                        <img id="preview-image-before-upload" class="card-img-top mt-5" alt="{{ $user->name }}" style="display: none; width: 200px; height: 200px;margin-left: auto;margin-right: auto;">
                    <div class="card-body">
                        @if( !$user->profile->image->url )
                            <p class="card-text">
                                No hay foto de perfil
                            </p>
                        @endif
                        <form action="{{ route('profile.update', $user) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                            <div class="form-group">
                                <label for="image">Click para seleccionar foto</label>
                                <input type="file" class="form-control-file" name="image" id="image" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Actualizar foto</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('js')
    <script type="text/javascript">

        $(document).ready(function (e) {
            $('#image').change(function(){
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#preview-image-after-upload').css('display', 'none');
                    $('#preview-image-before-upload').attr('src', e.target.result);
                    $('#preview-image-before-upload').css('display', 'block');
                }
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>
@endsection
