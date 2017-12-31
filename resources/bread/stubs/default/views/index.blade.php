@extends('laraback::layouts.app')

@section('title', 'bread_model_strings')
@section('content')
    <div class="row mb-4">
        <div class="col-md-auto">
            <h1 class="display-5">@yield('title')</h1>
        </div>
        <div class="col-md">
            @can('Add bread_model_strings')
                <button type="button" class="btn btn-primary" data-modal="{{ route('bread_model_variables.add') }}"><i class="fa fa-plus"></i> Add bread_model_string</button>
            @endcan
        </div>
    </div>

    <table id="bread_model_variables_datatable" class="table table-hover" cellspacing="0" width="100%">
        <thead>
        <tr>
            <!-- bread_datatable_heading -->
            <th class="actions">Actions</th>
        </tr>
        </thead>
    </table>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#bread_model_variables_datatable').DataTable({
                ajax: '{{ route('bread_model_variables.datatable') }}',
                columns: [
                    /* bread_datatable_column */
                    {
                        render: function (data, type, full) {
                            var actions = '';

                            @can('Edit bread_model_strings')
                                actions += ' <button type="button" class="btn btn-primary btn-icon" data-modal="{{ route('bread_model_variables.edit', ':id') }}" title="Edit"><i class="fa fa-fw fa-pencil-alt"></i></button> ';
                            @endcan
                            @can('Delete bread_model_strings')
                                actions += ' <button type="button" class="btn btn-danger btn-icon" data-modal="{{ route('delete', ['route' => 'bread_model_variables.delete', 'id' => ':id']) }}" title="Delete"><i class="fa fa-fw fa-trash"></i></button> ';
                            @endcan

                            return actions.replace(/:id/g, full.id);
                        }
                    }
                ]
            });
        });
    </script>
@endpush