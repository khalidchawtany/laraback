<?php

namespace Kjdion84\Laraback\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Kjdion84\Laraback\Traits\ValidateAjax;

class UserController extends Controller
{
    use ValidateAjax;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:Browse Users')->only(['index', 'indexDatatable']);
        $this->middleware('can:Add Users')->only(['addModal', 'add']);
        $this->middleware('can:Edit Users')->only(['editModal', 'edit', 'passwordModal', 'password']);
        $this->middleware('can:Delete Users')->only(['deleteModal', 'delete']);
    }

    // users index with table
    public function index()
    {
        return view('laraback::users.index');
    }

    // users index datatable
    public function indexDatatable()
    {
        $datatable = datatables()->of(app(config('auth.providers.users.model'))->with('roles')->get());
        $datatable->editColumn('roles', function ($user) {
            return $user->roles->sortBy('name')->pluck('name')->implode(', ');
        });

        return $datatable->toJson();
    }

    // show add user modal
    public function addModal()
    {
        $roles = app(config('laraback.models.role'))->get()->sortBy('name');

        return view('laraback::users.add', compact('roles'));
    }

    // add user
    public function add()
    {
        $this->validateAjax(request(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        request()->merge(['password' => Hash::make(request()->input('password'))]);
        $user = app(config('auth.providers.users.model'))->create(request()->all());
        $user->roles()->sync(request()->input('roles'));

        activity('Added User', request()->except(['password', 'password_confirmation']), $user);

        return response()->json([
            'flash' => ['success', 'User added!'],
            'dismiss_modal' => true,
            'reload_datatables' => true,
        ]);
    }

    // show edit user modal
    public function editModal($id)
    {
        $user = app(config('auth.providers.users.model'))->findOrFail($id);
        $roles = app(config('laraback.models.role'))->get()->sortBy('name');

        return view('laraback::users.edit', compact('user', 'roles'));
    }

    // edit user
    public function edit($id)
    {
        $this->validateAjax(request(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $user = app(config('auth.providers.users.model'))->findOrFail($id);
        $user->update(request()->all());
        $user->roles()->sync(request()->input('roles'));

        activity('Edited User', request()->all(), $user);

        return response()->json([
            'flash' => ['success', 'User edited!'],
            'dismiss_modal' => true,
            'reload_datatables' => true,
        ]);
    }

    // show change user password modal
    public function passwordModal($id)
    {
        $user = app(config('auth.providers.users.model'))->findOrFail($id);

        return view('laraback::users.password', compact('user'));
    }

    // change user password
    public function password($id)
    {
        $this->validateAjax(request(), [
            'password' => 'required|confirmed',
        ]);

        $user = app(config('auth.providers.users.model'))->findOrFail($id);
        $user->update(['password' => Hash::make(request()->input('password'))]);

        activity('Changed User Password', request()->except(['password', 'password_confirmation']), $user);

        return response()->json([
            'flash' => ['success', 'User password changed!'],
            'dismiss_modal' => true,
        ]);
    }

    // show delete user modal
    public function deleteModal($id)
    {
        $user = app(config('laraback.models.user'))->findOrFail($id);

        return view('laraback::users.delete', compact('user'));
    }

    // delete user
    public function delete($id)
    {
        $user = app(config('laraback.models.user'))->findOrFail($id);
        $user->delete();

        activity('Deleted User', $user->toArray(), $user);

        return response()->json([
            'flash' => ['success', 'User deleted!'],
            'dismiss_modal' => true,
            'reload_datatables' => true,
        ]);
    }
}