<?php

namespace Kjdion84\Laraback\Controllers;

use App\Http\Controllers\Controller;
use Kjdion84\Laraback\Traits\ValidateAjax;

class RoleController extends Controller
{
    use ValidateAjax;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:Browse Roles')->only(['index', 'indexDatatable']);
        $this->middleware('can:Add Roles')->only(['addModal', 'add']);
        $this->middleware('can:Edit Roles')->only(['editModal', 'edit']);
        $this->middleware('can:Delete Roles')->only(['deleteModal', 'delete']);
    }

    // roles index with table
    public function index()
    {
        return view('laraback::roles.index');
    }

    // roles index datatable
    public function indexDatatable()
    {
        return datatables()->of(app(config('laraback.models.role'))->get())->toJson();
    }

    // show add role modal
    public function addModal()
    {
        $group_permissions = app(config('laraback.models.permission'))->orderBy('group', 'asc')->orderBy('id', 'asc')->get()->groupBy('group');

        return view('laraback::roles.add', compact('group_permissions'));
    }

    // add role
    public function add()
    {
        $this->validateAjax(request(), [
            'name' => 'required|unique:roles',
        ]);

        $role = app(config('laraback.models.role'))->create(request()->all());
        $role->permissions()->sync(request()->input('permissions'));

        activity('Added Role', request()->all(), $role);

        return response()->json([
            'flash' => ['success', 'Role added!'],
            'dismiss_modal' => true,
            'reload_datatables' => true,
        ]);
    }

    // show edit role modal
    public function editModal($id)
    {
        $role = app(config('laraback.models.role'))->findOrFail($id);
        $group_permissions = app(config('laraback.models.permission'))->orderBy('group', 'asc')->orderBy('id', 'asc')->get()->groupBy('group');

        return view('laraback::roles.edit', compact('role', 'group_permissions'));
    }

    // edit role
    public function edit($id)
    {
        $this->validateAjax(request(), [
            'name' => 'required|unique:roles,name,' . $id,
        ]);

        $role = app(config('laraback.models.role'))->findOrFail($id);
        $role->update(request()->all());
        $role->permissions()->sync(request()->input('permissions'));

        activity('Edited Role', request()->all(), $role);

        return response()->json([
            'flash' => ['success', 'Role edited!'],
            'dismiss_modal' => true,
            'reload_datatables' => true,
        ]);
    }

    // show delete role modal
    public function deleteModal($id)
    {
        $role = app(config('laraback.models.role'))->findOrFail($id);

        return view('laraback::roles.delete', compact('role'));
    }

    // delete role
    public function delete($id)
    {
        $role = app(config('laraback.models.role'))->findOrFail($id);
        $role->delete();

        activity('Deleted Role', $role->toArray(), $role);

        return response()->json([
            'flash' => ['success', 'Role deleted!'],
            'dismiss_modal' => true,
            'reload_datatables' => true,
        ]);
    }
}