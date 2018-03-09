@extends('laraback::layouts.app')

@section('title', 'Settings')
@section('content')
    <h1 class="display-5 mb-4">@yield('title')</h1>

    <form method="POST" action="{{ route('settings') }}" novalidate>
        {{ method_field('PATCH') }}
        {{ csrf_field() }}

        <div class="form-group">
            <label for="default_timezone">Default Timezone</label>
            <select name="default_timezone" id="default_timezone" class="form-control">
                @foreach(timezones() as $timezone)
                    <option value="{{ $timezone->name }}"{{ config('settings.default_timezone') == $timezone->name ? ' selected' : '' }}>{{ $timezone->label }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Edit Settings</button>
    </form>
@endsection