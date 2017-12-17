<?php

namespace Kjdion84\Laraback\Controllers;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    // redirect based on auth
    public function index()
    {
        if (auth()->guest()) {
            return redirect()->route('login');
        }
        else {
            return redirect()->route('dashboard');
        }
    }

    // redirect home to index
    public function homeRedirect()
    {
        return redirect()->route('index');
    }
}