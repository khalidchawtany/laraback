@extends('laraback::layouts.modal')

@section('title', 'Delete bread_model_string')
@section('content')
    <div class="modal-body">
        <p>Are you sure you want to delete this bread_model_string?</p>
    </div>

    <div class="modal-footer">
        <form method="POST" action="{{ route('bread_model_variables.delete', $bread_model_variable->id) }}" novalidate>
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
            <button type="submit" class="btn btn-danger">Yes</button>
        </form>

        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
    </div>
@endsection