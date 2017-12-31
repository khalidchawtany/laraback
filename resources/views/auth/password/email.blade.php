@extends('laraback::layouts.auth')

@section('title', 'Email Password Reset Link')
@section('form')
    <form method="POST" action="{{ route('password.email') }}" novalidate>
        {{ csrf_field() }}

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" name="email" id="email" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">@yield('title')</button>
    </form>
@endsection