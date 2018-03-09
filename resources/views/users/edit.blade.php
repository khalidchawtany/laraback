@extends('laraback::layouts.modal')

@section('title', 'Edit User')
@section('content')
    <form method="POST" action="{{ route('users.edit', $user->id) }}" novalidate>
        {{ method_field('PATCH') }}
        {{ csrf_field() }}

        <div class="modal-body">
            <div class="form-group">
                <label for="name">Name</label>
                <input name="name" id="name" class="form-control" value="{{ $user->name }}">
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}">
            </div>

            <div class="form-group">
                <label for="timezone">Timezone</label>
                <select name="timezone" id="timezone" class="form-control">
                    @foreach(timezones() as $timezone)
                        <option value="{{ $timezone->name }}"{{ $user->timezone == $timezone->name ? ' selected' : '' }}>{{ $timezone->label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Roles</label>
                <div class="mb-2">
                    <button type="button" class="btn btn-primary btn-sm" data-check-all="roles[]"><i class="fa fa-check-square"></i> Check All</button>
                    <button type="button" class="btn btn-primary btn-sm" data-uncheck-all="roles[]"><i class="fa fa-square"></i> Uncheck All</button>
                </div>
                @foreach ($roles as $role)
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" name="roles[]" class="form-check-input" value="{{ $role->id }}"{{ $user->roles->contains('id', $role->id) ? ' checked' : '' }}>
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