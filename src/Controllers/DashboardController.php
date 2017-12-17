<?php

namespace Kjdion84\Laraback\Controllers;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // show dashboard view
    public function index()
    {
        return view('laraback::dashboard.index');
    }

    // show delete confirmation modal
    public function deleteModal($route, $id)
    {
        return view('laraback::dashboard.delete', compact('route', 'id'));
    }
}