@extends('laraback::layouts.app')

@section('title', 'Edit Profile')
@section('content')
    <h1 class="display-5 mb-4">@yield('title')</h1>

    <form method="POST" action="{{ route('profile') }}" novalidate>
        {{ method_field('PATCH') }}
        {{ csrf_field() }}

        <div class="form-group">
            <label for="name">Name</label>
            <input name="name" id="name" class="form-control" value="{{ auth()->user()->name }}">
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ auth()->user()->email }}">
        </div>

        <div class="form-group">
            <label for="timezone">Timezone</label>
            <select name="timezone" id="timezone" class="form-control">
                @foreach(timezones() as $timezone)
                    <option value="{{ $timezone->name }}"{{ auth()->user()->timezone == $timezone->name ? ' selected' : '' }}>{{ $timezone->label }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">@yield('title')</button>
    </form>
@endsection