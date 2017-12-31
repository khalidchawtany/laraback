<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('laraback/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('laraback/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('laraback/css/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('laraback/css/laraback.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body{!! session('flash') ? ' data-flash-class="'.session('flash.0').'" data-flash-message="'.session('flash.1').'"' : '' !!}>

@if(auth()->guest())
    @yield('content')
@else
    <nav class="navbar navbar-expand navbar-dark bg-primary">
        <a class="sidebar-toggle text-light mr-3"><i class="fa fa-bars"></i></a>
        <a class="navbar-brand" href="{{ route('index') }}">{{ config('app.name') }}</a>

        <div class="navbar-collapse collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" data-toggle="dropdown">
                        <i class="fa fa-user"></i> {{ auth()->user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item{!! request()->is('profile') ?  ' active' : '' !!}" href="{{ route('profile') }}">Edit Profile</a>
                        <a class="dropdown-item{!! request()->is('password/change') ?  ' active' : '' !!}" href="{{ route('password.change') }}">Change Password</a>
                        <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="d-flex">
        <div class="sidebar bg-dark">
            <ul class="list-unstyled mb-0">
                <li{!! request()->is('dashboard') ?  ' class="active"' : '' !!}><a href="{{ route('dashboard') }}"><i class="fa fa-fw fa-tachometer-alt"></i> Dashboard</a></li>
                <!-- bread_navbar -->
                @can('Edit Settings')
                    <li{!! request()->is('settings') ?  ' class="active"' : '' !!}><a href="{{ route('settings') }}"><i class="fa fa-fw fa-cog"></i> Settings</a></li>
                @endcan
                @can('Browse Roles')
                    <li{!! request()->is('roles') ?  ' class="active"' : '' !!}><a href="{{ route('roles') }}"><i class="fa fa-fw fa-shield-alt"></i> Roles</a></li>
                @endcan
                @can('Browse Users')
                    <li{!! request()->is('users') ?  ' class="active"' : '' !!}><a href="{{ route('users') }}"><i class="fa fa-fw fa-users"></i> Users</a></li>
                @endcan
            </ul>
        </div>

        <div class="content p-4">
            @yield('content')
        </div>
    </div>
@endif

<!-- Scripts -->
<script src="{{ asset('laraback/js/jquery.min.js') }}"></script>
<script src="{{ asset('laraback/js/popper.min.js') }}"></script>
<script src="{{ asset('laraback/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('laraback/js/datatables.min.js') }}"></script>
<script src="{{ asset('laraback/js/moment.min.js') }}"></script>
<script src="{{ asset('laraback/js/moment-timezone.min.js') }}"></script>
<script src="{{ asset('laraback/js/laraback.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')

</body>
</html>