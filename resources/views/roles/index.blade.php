@extends('laraback::layouts.app')

@section('title', 'Roles')
@section('content')
    <div class="row mb-4">
        <div class="col">
            <h1 class="display-5">@yield('title')</h1>
        </div>
        <div class="col text-right">
            @can('Add Roles')
                <button type="button" class="btn btn-primary btn-icon" data-modal="{{ route('roles.add') }}" title="Add"><i class="fa fa-fw fa-plus"></i></button>
            @endcan
        </div>
    </div>

    <table id="roles_datatable" class="table table-hover" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Name</th>
            <th class="actions">Actions</th>
        </tr>
        </thead>
    </table>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#roles_datatable').DataTable({
                ajax: '{{ route('roles.datatable') }}',
                columns: [
                    { data: 'name' },
                    {
                        render: function (data, type, full) {
                            var actions = '';

                            if (full.id !== '1') {
                                @can('Edit Roles')
                                    actions += ' <button type="button" class="btn btn-primary btn-icon" data-modal="{{ route('roles.edit', ':id') }}" title="Edit"><i class="fa fa-fw fa-pencil-alt"></i></button> ';
                                @endcan
                                @can('Delete Roles')
                                    actions += ' <button type="button" class="btn btn-danger btn-icon" data-modal="{{ route('delete', ['route' => 'roles.delete', 'id' => ':id']) }}" title="Delete"><i class="fa fa-fw fa-trash"></i></button> ';
                                @endcan
                            }

                            return actions.replace(/:id/g, full.id);
                        }
                    }
                ]
            });
        });
    </script>
@endpush