@extends('laraback::layouts.app')

@section('content')
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-lg-4 col-md-6">
                <h1 class="display-5 mb-4 text-center">{{ config('app.name') }}</h1>
                <div class="card">
                    <div class="card-body">
                        @yield('form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection