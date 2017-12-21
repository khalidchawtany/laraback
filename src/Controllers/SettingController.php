<?php

namespace Kjdion84\Laraback\Controllers;

use App\Http\Controllers\Controller;
use Kjdion84\Laraback\Traits\ValidateAjax;

class SettingController extends Controller
{
    use ValidateAjax;
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:Edit Settings');
    }
    
    public function editForm()
    {
        return view('laraback::settings.edit');
    }
    
    public function edit()
    {
        $this->validateAjax(request(), [
            'example' => 'required',
        ]);
        
        foreach (request()->all() as $key => $value) {
            if ($setting = app(config('laraback.models.setting'))->where('key', $key)->first()) {
                $setting->update(['value' => $value]);
            }
        }
        
        activity('Edited Settings', request()->all());
        flash('success', 'Settings edited!');
        
        return response()->json(['reload_page' => true]);
    }
}