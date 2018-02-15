@extends('laraback::layouts.app')

@section('title', $user->name.' Activity')
@section('content')
    <h1 class="display-5 mb-4">@yield('title')</h1>

    <table id="activities_user_datatable" class="table table-hover" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Date</th>
            <th>Log</th>
            <th class="actions">Actions</th>
        </tr>
        </thead>
    </table>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#activities_user_datatable').DataTable({
                ajax: '{{ route('activities.user.datatable', $user->id) }}',
                order: [[ 0, 'desc' ]],
                columns: [
                    { data: 'created_at' },
                    { data: 'log' },
                    {
                        render: function (data, type, full) {
                            var actions = '';

                            @can('Read Activities')
                                actions += ' <button type="button" class="btn btn-primary btn-icon tooltipster" data-modal="{{ route('activities.data', ':id') }}" title="Data"><i class="fa fa-fw fa-database"></i></button> ';
                            @endcan

                            return actions.replace(/:id/g, full.id);
                        }
                    }
                ]
            });
        });
    </script>
@endpush