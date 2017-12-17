@extends('laraback::layouts.app')

@section('title', 'Activities')
@section('content')
    <h1 class="display-5 mb-4">@yield('title')</h1>

    <table id="activities_datatable" class="table table-hover" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>User</th>
            <th>Log</th>
            <th>Date</th>
            <th class="actions">Actions</th>
        </tr>
        </thead>
    </table>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#activities_datatable').DataTable({
                ajax: '{{ route('activities.datatable') }}',
                order: [[ 2, 'desc' ]],
                columns: [
                    { data: 'user.name' },
                    { data: 'log' },
                    { data: 'created_at', className: 'timezone' },
                    {
                        render: function (data, type, full) {
                            var actions = '';

                            @can('Read Activities')
                                actions += ' <button type="button" class="btn btn-primary btn-icon" data-modal="{{ route('activities.data', ':id') }}" title="Data"><i class="fa fa-fw fa-database"></i></button> ';
                            @endcan

                            return actions.replace(/:id/g, full.id);
                        }
                    }
                ]
            });
        });
    </script>
@endpush