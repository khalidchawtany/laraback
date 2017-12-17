@extends('laraback::layouts.app')

@section('title', 'Email Password Reset Link')
@section('content')
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('password.email') }}" novalidate>
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary">Email Password Reset Link</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection