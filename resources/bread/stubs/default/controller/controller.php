<?php

/* bread_controller_namespace */

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

/* bread_model_use */

use App\Http\Requests\bread_model_classes\Storebread_model_class;
use App\Http\Requests\bread_model_classes\Updatebread_model_class;
use App\Http\Requests\bread_model_classes\Removebread_model_class;

class bread_controller_class extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'user.id']);
        $this->middleware('permission:view_bread_model_variable', ['only' => ['paginate', 'jsonList']]);
        $this->middleware('permission:create_bread_model_variable', ['only' => ['create']]);
        $this->middleware('permission:update_bread_model_variable', ['only' => ['update']]);
        $this->middleware('permission:destroy_bread_model_variable', ['only' => ['destroy']]);
    }

    public function paginate(Request $request)
    {
        return QueryBuilder::for(bread_model_class::class)
            ->allowedFilters("/* bread_fillable */")
            ->jsonPaginate();
    }

    public function jsonList(Request $request)
    {
        $query = bread_model_class::selectRaw('bread_model_variables.name, bread_model_variables.id');
        if ($request->filled('q')) {
            $query = $query->where('name', 'like', "{$request->q}%");
        }
        return $query->limit(10)->get()->toArray();
    }

    protected function create(Storebread_model_class $request)
    {
        $bread_model_variable = bread_model_class::create($request->input());

        return ezReturnSuccessMessage('bread_model_string created successfully!', $bread_model_variable);
    }

    public function update(Updatebread_model_class $request, bread_model_class $bread_model_variable)
    {
        $bread_model_variable->update($request->input());

        return ezReturnSuccessMessage('bread_model_class updated successfully!', $bread_model_variable);
    }

    public function destroy(bread_model_class $bread_model_variable)
    {
        $bread_model_variable->delete();

        return ezReturnSuccessMessage('bread_model_class removed successfully!', $bread_model_variable);
    }

}