@extends('laraback::layouts.auth')

@section('title', 'Login')
@section('form')
    @if (config('laraback.demo'))
        <p class="text-danger"><b>Warning:</b> app is currently in demo mode, some features are disabled.</p>
    @endif

    <form method="POST" action="{{ route('login') }}" novalidate>
        {{ csrf_field() }}

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ config('laraback.demo') ? 'admin@example.com' : '' }}">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" value="{{ config('laraback.demo') ? 'admin123' : '' }}">
        </div>

        <div class="form-check mb-3">
            <label class="form-check-label">
                <input type="checkbox" name="remember" class="form-check-input">
                Remember Me
            </label>
        </div>

        <button type="submit" class="btn btn-primary">@yield('title')</button>
        <a class="btn btn-link" href="{{ route('password.email') }}">Forgot Password</a>
    </form>
@endsection