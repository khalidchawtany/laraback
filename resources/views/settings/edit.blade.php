@extends('laraback::layouts.app')

@section('title', 'Settings')
@section('content')
    <h1 class="display-5 mb-4">@yield('title')</h1>

    <form method="POST" action="{{ route('settings') }}" novalidate>
        {{ method_field('PATCH') }}
        {{ csrf_field() }}

        <div class="form-group">
            <label for="example">Example</label>
            <input name="example" id="example" class="form-control" value="{{ config('settings.example') }}">
        </div>

        <button type="submit" class="btn btn-primary">Edit</button>
    </form>
@endsection