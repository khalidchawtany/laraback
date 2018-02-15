@extends('laraback::layouts.app')

@section('title', 'Users')
@section('content')
    <div class="row mb-4 align-items-center">
        <div class="col-md-auto">
            <h1 class="display-5">@yield('title')</h1>
        </div>
        <div class="col-md">
            @can('Add Users')
                <button type="button" class="btn btn-primary" data-modal="{{ route('users.add') }}"><i class="fa fa-plus"></i> Add User</button>
            @endcan
            @can('Browse Activities')
                <a href="{{ route('activities') }}" class="btn btn-primary"><i class="fa fa-history"></i> View Activity</a>
            @endcan
        </div>
    </div>

    <table id="users_datatable" class="table table-hover" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email Address</th>
            <th>Roles</th>
            <th class="actions">Actions</th>
        </tr>
        </thead>
    </table>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#users_datatable').DataTable({
                ajax: '{{ route('users.datatable') }}',
                columns: [
                    { data: 'name' },
                    { data: 'email' },
                    { data: 'roles', sortable: false },
                    {
                        render: function (data, type, full) {
                            var actions = '';

                            @can('Browse Activities')
                                actions += ' <a href="{{ route('activities.user', ':id') }}" class="btn btn-primary btn-icon tooltipster" title="Activity"><i class="fa fa-fw fa-history"></i></a> ';
                            @endcan
                            @can('Edit Users')
                                actions += ' <button type="button" class="btn btn-primary btn-icon tooltipster" data-modal="{{ route('users.edit', ':id') }}" title="Edit"><i class="fa fa-fw fa-pencil-alt"></i></button> ';
                                actions += ' <button type="button" class="btn btn-primary btn-icon tooltipster" data-modal="{{ route('users.password', ':id') }}" title="Change Password"><i class="fa fa-fw fa-lock"></i></button> ';
                            @endcan
                            @can('Delete Users')
                                actions += ' <button type="button" class="btn btn-danger btn-icon tooltipster" data-modal="{{ route('users.delete', ':id') }}" title="Delete"><i class="fa fa-fw fa-trash"></i></button> ';
                            @endcan

                            return actions.replace(/:id/g, full.id);
                        }
                    }
                ]
            });
        });
    </script>
@endpush