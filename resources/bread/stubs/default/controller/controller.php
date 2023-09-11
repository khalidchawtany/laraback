<?php

/* bread_controller_namespace */

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Adapters\JQueryBuilder;
/* bread_model_use */

use App\Http\Requests\bread_model_classes\Storebread_model_class;
use App\Http\Requests\bread_model_classes\Updatebread_model_class;
use App\Http\Requests\bread_model_classes\Removebread_model_class;

class bread_controller_class extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'user.id']);
        $this->middleware('permission:view_bread_model_variable', ['only' => ['index', 'list']]);
        $this->middleware('permission:create_bread_model_variable', ['only' => ['create']]);
        $this->middleware('permission:update_bread_model_variable', ['only' => ['update']]);
        $this->middleware('permission:destroy_bread_model_variable', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('bread_controller_viewbread_model_variables.index');
    }

    public function showbread_model_classDialog(Request $request)
    {
        if ($request->has('id')) {
            $bread_model_variable = bread_model_class::findOrFail($request->id);

            return view('bread_model_variables.bread_model_variable_dialog', compact('bread_model_variable'));
        }

        return view('bread_model_variables.bread_model_variable_dialog');
    }

    public function list(Request $request)
    {
        return JQueryBuilder::for(bread_model_class::class)
        ->leftJoin('users', 'users.id', 'bread_model_variables.user_id')
        ->select([
            'bread_model_variables.*',
            'users.name as user_name',
        ])

        ->allowedFilters([
            '/* bread_fillable */',
            'users.name'
        ])
        ->jsonJPaginate();
    }

    public function jsonList(Request $request)
    {
        $col = bread_model_class::query()
            ->select([
                'id',
                'name',
            ])
            ->when(
                $request->has('q'),
                fn ($q) => $q->where('name', 'like', "%{$request->q}%")
                    // ->orWhere('address', 'like', "%{$request->q}%")
            )
            ->limit(10)
            ->get();

        if ($request->has('prependNone')) {
            return prependNone(
                $col,
                ['id' => 0, 'display_text' => __('All')]
            );
        }

        return $col;
    }

    protected function create(Storebread_model_class $request)
    {
        $bread_model_variable = bread_model_class::create($request->input());

        return ezReturnSuccessMessage('bread_model_string created successfully!', $bread_model_variable);
    }

    public function update(Updatebread_model_class $request)
    {
    	$bread_model_variable = bread_model_class::findOrFail($request->id);

        $bread_model_variable->update($request->input());

        return ezReturnSuccessMessage('bread_model_string updated successfully!', $bread_model_variable);
    }

    public function destroy(Removebread_model_class $request)
    {

    	$bread_model_variable = bread_model_class::findOrFail($request->id);

    	$bread_model_variable->delete();

    	return ezReturnSuccessMessage('bread_model_string removed successfully!');

    }

}
