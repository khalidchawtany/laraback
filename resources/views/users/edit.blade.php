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
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}">
            </div>

            <div class="form-group">
                <div>
                    <label>Roles</label>
                    <button type="button" class="btn btn-secondary btn-sm ml-1" data-check-all="roles[]" title="Check All"><i class="far fa-check-square"></i></button>
                    <button type="button" class="btn btn-secondary btn-sm" data-check-none="roles[]" title="Check None"><i class="far fa-square"></i></button>
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
            <button type="submit" class="btn btn-primary">Edit</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
    </form>
@endsection