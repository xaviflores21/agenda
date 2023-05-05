<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
        <!-- CSRF Token -->
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}" crossorigin="anonymous">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        @yield('scripts')
    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <span style="padding-right: 15px;"></span>
                    <a class="navbar-brand" href="{{ url('/') }}" style="height: 60px;">
                        <img src="{{ asset('/logo/losTajibos.jpeg') }}" alt="Logo" style="width: 100%; height: 100%;">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav me-auto">
                            </ul>
                            <!-- Right Side Of Navbar -->
                            <ul class="navbar-nav ms-auto">
                                <!-- Authentication Links -->
                                @if (Route::has('login'))
                                @auth
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        {{ __('Cerrar sesion') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                        <a class="dropdown-item" href="{{ route('usuariosTable.index') }}">{{ __('Gestor de usuarios') }}</a>
                                    </div>
                                </li>
                                @auth
                                @if(in_array(Auth::user()->role, ['admin', 'Jefe de area']))
                                @if (Route::currentRouteName() != 'login')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Registrar') }}</a>
                                </li>
                                @endif
                                <!-- Reporte LINK -->
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>{{ __('Reporte') }}</a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('reporte.index') }}">{{ __('Reporte de eventos') }}</a>
                                    <a class="dropdown-item" href="{{ route('reporteUsuarios.index') }}">{{ __('Reporte de usuarios') }}</a>
                                    <a class="dropdown-item" href="{{ route('reportePersona.index') }}">{{ __('Reporte de personal') }}</a>
                                    <a class="dropdown-item" href="{{ route('reporteHorario.index') }}">{{ __('Reporte de horarios') }}</a>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('personas.index') }}">{{ __('Registar personal') }}</a>
                                </li>
                                <!-- Modal -->
                                <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Añadir Personal</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{ route('personas.addName') }}">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="nombreCompleto" class="form-label">Nombre Completo</label>
                                                        <input type="text" class="form-control" id="nombreCompleto" name="nombreCompleto" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Añadir personal</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endauth
                                @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Iniciar sesion') }}</a>
                                </li>
                                <li class="nav-item">
                                    @if (Route::currentRouteName() != 'login') <!-- add this conditional statement -->
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Registrar') }}</a>
                                    @endif
                                </li>
                                @endauth
                                @endif
                            </ul>
                        </div>
                    </div>
                </nav>
                
                <main class="py-4">
                    <div class="container">
                        @yield('content')
                    </div>
                </main>
            </div>
        </body>
        
        </html>
