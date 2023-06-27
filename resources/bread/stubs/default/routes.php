// bread_model_variable routes
Route::get('bread_model_variables', [bread_controller_routes::class, 'index']);
Route::get('bread_model_variables/list', [bread_controller_routes::class, 'list']);
Route::get('bread_model_variables/dialog', [bread_controller_routes::class, 'showbread_model_classDialog']);
Route::post('bread_model_variables/create', [bread_controller_routes::class, 'create']);
Route::post('bread_model_variables/update', [bread_controller_routes::class, 'update']);
Route::post('bread_model_variables/destroy', [bread_controller_routes::class, 'destroy']);
