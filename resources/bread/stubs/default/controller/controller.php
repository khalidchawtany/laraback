<?php

/* bread_controller_namespace */

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

/* bread_model_use */

use App\Http\Requests\bread_model_class\Storebread_model_class;
use App\Http\Requests\bread_model_class\Updatebread_model_class;
use App\Http\Requests\bread_model_class\Removebread_model_class;

class bread_controller_class extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('bread_controller_viewbread_model_variables.index');
    }

    public function list(Request $request)
    {
        return QueryBuilder::for(bread_model_class::class)
        ->allowedFilters("/* bread_fillable */")
        ->jsonPaginate();
    }

    protected function create(Storebread_model_class $request)
    {
        $bread_model_variable = bread_model_class::create($request->input());

        return ezReturnSuccessMessage('bread_model_string created successfully!', $bread_model_variable->id);
    }

    public function update(Updatebread_model_class $request)
    {
    	$bread_model_variable = bread_model_class::findOrFail($request->id);

        $bread_model_variable->update($request->input());

        return ezReturnSuccessMessage('bread_model_string updated successfully!');
    }

    public function destroy(Request $request)
    {

    	$bread_model_variable = bread_model_class::findOrFail($request->id);

    	$bread_model_variable->delete();

    	return ezReturnSuccessMessage('bread_model_string removed successfully!');

    }

}