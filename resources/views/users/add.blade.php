@extends('laraback::layouts.modal')

@section('title', 'Add User')
@section('content')
    <form method="POST" action="{{ route('users.add') }}" novalidate>
        {{ csrf_field() }}

        <div class="modal-body">
            <div class="form-group">
                <label for="name">Name</label>
                <input name="name" id="name" class="form-control">
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" class="form-control">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            </div>

            <div class="form-group">
                <label>Roles</label>
                <div class="mb-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-check-all="roles[]"><i class="fa fa-check-square"></i> Check All</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-uncheck-all="roles[]"><i class="fa fa-square"></i> Uncheck All</button>
                </div>
                @foreach ($roles as $role)
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" name="roles[]" class="form-check-input" value="{{ $role->id }}">
                            {{ $role->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">@yield('title')</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
    </form>
@endsection