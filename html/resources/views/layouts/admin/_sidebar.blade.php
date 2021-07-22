<div class="sidebar" data-color="azure" data-background-color="white" style="overflow-y: auto;">
    <!--
       Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

       Tip 2: you can also add an image using data-image tag
       -->
    <div class="logo" align='center'>
        <img src="https://cdn0.iconfinder.com/data/icons/customicondesignoffice5/256/examples.png">
    </div>
    @if( auth()->user() && auth()->user()->profile->image->url )
        <div class="text-center logo">
            <img style="border-radius: 50% !important;width: 150px;height: 150px;" src="{{ asset(auth()->user()->profile->image->url) }}" class="rounded img-fluid img-thumbnail" alt="image">
        </div>
    @endif
    <div class="sidebar-wrapper">
       <ul class="nav">
            @guest
                <li class="nav-item active">
                <a class="nav-link" href="{{ route('login') }}">
                    <i class="material-icons">account_circle</i>
                    <p>Login</p>
                </a>
                </li>
            @else
           <li class="nav-item {{ setActiveAdmin('profile.me') }}">
               <a class="nav-link" href="{{ route('profile.me') }}">
                   <i class="material-icons">person</i>
                   <p>Mi Perfil</p>
               </a>
           </li>
            @if ( auth::user()->hasRoles(['Administrador']))

                <li class="nav-item {{ setActiveAdmin('home') }}">
                    <a class="nav-link" href="{{ route('login') }}">
                        <i class="material-icons">home</i>
                        <p>Home</p>
                    </a>
                </li>

                <li class="nav-item {{ setActiveAdmin('users.*') }}">
                    <a class="nav-link" href="{{ route('users.index') }}">
                    <i class="material-icons">groups</i>
                        <p>Usuarios</p>
                    </a>
                </li>

                <li class="nav-item {{ setActiveAdmin('campaigns.*') }}">
                    <a class="nav-link" href="{{ route('campaigns.index') }}">
                    <i class="material-icons">api</i>
                        <p>Campañas</p>
                    </a>
                </li>

                @if( isset($campaign->name) )
                    <li class="nav-item" style="background:rgb(240, 240, 240)">
                        <a class="nav-link collapsed" data-toggle="collapse" href="#tablesExamples" aria-expanded="false">
                            <i class="material-icons">bookmarks</i>
                            <p style="overflow: hidden" data-toggle="tooltip" data-placement="top" title="{{ $campaign->name }}">
                                {{ $campaign->name }}
                            </p>
                        </a>
                        <div class="collapse" id="tablesExamples" style="display: block">
                            <ul class="nav">
                                <li class="nav-item {{ setActiveAdmin('producers.resumen') }}">
                                    <a class="nav-link" href="{{ route('producers.resumen', $campaign) }}">
                                    <i class="material-icons">dashboard</i>
                                        <p>Dashboard</p>
                                    </a>
                                </li>

                                <li class="nav-item {{ setActiveAdmin('producers.documentacion') }} {{ setActiveAdmin('producers.documentacion-add') }}">
                                    <a class="nav-link" href="{{ route('producers.documentacion', $campaign) }}">
                                    <i class="material-icons">sticky_note_2</i>
                                        <p>Documentación</p>
                                    </a>
                                </li>

                                <li class="nav-item {{ setActiveAdmin('producers.facturas') }} {{ setActiveAdmin('producers.facturas-add') }}">
                                    <a class="nav-link" href="{{ route('producers.facturas', $campaign) }}">
                                        <i class="material-icons">monetization_on</i>
                                        <p>Facturas</p>
                                    </a>
                                </li>

                                <li class="nav-item {{ setActiveAdmin('producers.entrada-datos') }} {{ setActiveAdmin('producers.gastos') }}">
                                    <a class="nav-link" href="{{ route('producers.entrada-datos', $campaign) }}">
                                        <i class="material-icons">keyboard</i>
                                        <p>Entrada de datos</p>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link collapsed" data-toggle="collapse" href="#tabPosicionGlobal" aria-expanded="false">
                        <i class="material-icons">paid</i>
                        <p> Posición Global
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div
                        class="collapse"
                        id="tabPosicionGlobal"
                        style="display: {{ ( setActiveAdmin('posicion-global.*') == 'active' ) ? "block" : "" }}"
                    >
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('posicion-global.rules-index') }}">
                                <i class="material-icons">rule</i>
                                    <p>Reglas</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('posicion-global.index') }}">
                                <i class="material-icons">table_chart</i>
                                    <p>Tabla</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{--  <li class="nav-item {{ setActiveAdmin('posicion-global.*') }}">
                    <a class="nav-link" href="{{ route('posicion-global.index') }}">
                    <i class="material-icons">paid</i>
                        <p>Posición Global</p>
                    </a>
                </li>  --}}


                 {{-- <li class="nav-item {{ setActiveAdmin('budgets.*') }}">
                    <a class="nav-link " href="{{ route('budgets.index') }}">
                        <i class="material-icons">attach_money</i>
                        <p>Facturas acumulado</p>
                    </a>
                </li> --}}

                <li class="nav-item">
                    <a class="nav-link collapsed" data-toggle="collapse" href="#tablesExamples" aria-expanded="false">
                        <i class="material-icons">bookmarks</i>
                        <p> Maestros
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div    class="collapse"
                            id="tablesExamples"
                            style="display: {{ ( setActiveAdmin('advertisers.*') == 'active' || setActiveAdmin('clients.*') == 'active' || setActiveAdmin('influencers.*') == 'active' || setActiveAdmin('dealers.*') == 'active' ) ? "block" : "" }}"
                    >
                        <ul class="nav">
                            <li class="nav-item {{ setActiveAdmin('advertisers.*') }}">
                                <a class="nav-link" href="{{ route('advertisers.index') }}">
                                <i class="material-icons">group_work</i>
                                    <p>Anunciantes</p>
                                </a>
                            </li>

                            <li class="nav-item {{ setActiveAdmin('clients.*') }}">
                                <a class="nav-link" href="{{ route('clients.index') }}">
                                <i class="material-icons">group</i>
                                    <p>Clientes</p>
                                </a>
                            </li>

                            <li class="nav-item {{ setActiveAdmin('influencers.*') }}">
                                <a class="nav-link" href="{{ route('influencers.index') }}">
                                    <i class="material-icons">movie_filter</i>
                                    <p>Influencers</p>
                                </a>
                            </li>

                            <li class="nav-item {{ setActiveAdmin('dealers.*') }}">
                                <a class="nav-link" href="{{ route('dealers.index') }}">
                                    <i class="material-icons">assignment_ind</i>
                                    <p>Proveedores</p>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>




            @elseif ( auth::user()->hasRoles(["Producer"]) )

                <li class="nav-item {{ setActiveAdmin('producers.dashboard') }}">
                    <a class="nav-link " href="{{ route('producers.dashboard') }}">
                        <i class="material-icons">home</i>
                        <p>Home</p>
                    </a>
                </li>

                @if( isset($campaign->name) )
                    <li class="nav-item">
                        <a class="nav-link collapsed" data-toggle="collapse" href="#tablesExamples" aria-expanded="false">
                            <i class="material-icons">bookmarks</i>
                            <p> {{ $campaign->name }}
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="tablesExamples" style="display: block;">
                            <ul class="nav">
                                <li class="nav-item {{ setActiveAdmin('producers.resumen') }}">
                                    <a class="nav-link" href="{{ route('producers.resumen', $campaign) }}">
                                    <i class="material-icons">dashboard</i>
                                        <p>Dashboard</p>
                                    </a>
                                </li>

                                <li class="nav-item {{ setActiveAdmin('producers.documentacion') }} {{ setActiveAdmin('producers.documentacion-add') }}">
                                    <a class="nav-link" href="{{ route('producers.documentacion', $campaign) }}">
                                    <i class="material-icons">sticky_note_2</i>
                                        <p>Documentación</p>
                                    </a>
                                </li>

                                <li class="nav-item {{ setActiveAdmin('producers.facturas') }} {{ setActiveAdmin('producers.facturas-add') }}">
                                    <a class="nav-link" href="{{ route('producers.facturas', $campaign) }}">
                                        <i class="material-icons">monetization_on</i>
                                        <p>Facturas</p>
                                    </a>
                                </li>

                                <li class="nav-item {{ setActiveAdmin('producers.entrada-datos') }} {{ setActiveAdmin('producers.gastos') }}">
                                    <a class="nav-link" href="{{ route('producers.entrada-datos', $campaign) }}">
                                        <i class="material-icons">keyboard</i>
                                        <p>Entrada de datos</p>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>
                @endif

            @elseif( auth::user()->hasRoles(["Ejecutivo"]) )

                <li class="nav-item {{ setActiveAdmin('producers.dashboard') }}">
                    <a class="nav-link " href="{{ route('producers.dashboard') }}">
                        <i class="material-icons">home</i>
                        <p>Home</p>
                    </a>
                </li>

                @if( isset($campaign->name) )
                    <li class="nav-item">
                        <a class="nav-link collapsed" data-toggle="collapse" href="#tablesExamples" aria-expanded="false">
                            <i class="material-icons">bookmarks</i>
                            <p> {{ $campaign->name }}
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="tablesExamples" style="display: block;">
                            <ul class="nav">
                                <li class="nav-item {{ setActiveAdmin('producers.facturas') }} {{ setActiveAdmin('producers.facturas-add') }}">
                                    <a class="nav-link" href="{{ route('producers.facturas', $campaign) }}">
                                        <i class="material-icons">monetization_on</i>
                                        <p>Facturas</p>
                                    </a>
                                </li>

                                <li class="nav-item {{ setActiveAdmin('producers.entrada-datos') }} {{ setActiveAdmin('producers.gastos') }}">
                                    <a class="nav-link" href="{{ route('producers.entrada-datos', $campaign) }}">
                                        <i class="material-icons">keyboard</i>
                                        <p>Entrada de datos</p>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>
                @endif

            @endif

                <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="material-icons">exit_to_app</i>
                    <p>{{ __('Cerrar Session') }}</p>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                </form>
                </li>

            @endguest
            <!-- your sidebar here -->
       </ul>
    </div>
 </div>
