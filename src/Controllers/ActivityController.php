<?php

namespace Kjdion84\Laraback\Controllers;

use App\Http\Controllers\Controller;

class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:Browse Activities')->except('dataModal');
        $this->middleware('can:Read Activities')->only('dataModal');
    }

    public function index()
    {
        return view('laraback::activities.index');
    }

    public function indexDatatable()
    {
        $datatable = datatables()->of(app(config('laraback.models.activity'))->with('user')->get());
        $datatable->editColumn('user.name', function ($activity) {
            return $activity->user ? $activity->user->name : 'System';
        });

        return $datatable->toJson();
    }

    public function dataModal($id)
    {
        $activity = app(config('laraback.models.activity'))->findOrFail($id);
        $user = app(config('auth.providers.users.model'))->find($activity->user_id);
        $model = $activity->model_class ? app($activity->model_class)->find($activity->model_id) : null;

        return view('laraback::activities.data', compact('activity', 'user', 'model'));
    }

    public function user($id)
    {
        $user = app(config('auth.providers.users.model'))->findOrFail($id);

        return view('laraback::activities.user', compact('user'));
    }

    public function userDatatable($id)
    {
        return datatables()->of(app(config('laraback.models.activity'))->where('user_id', $id)->get())->toJson();
    }
}