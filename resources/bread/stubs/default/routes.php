// bread_model_variable routes
Route::get('/bread_model_variables', 'bread_controller_routes@index');
Route::get('/bread_model_variables/list', 'bread_controller_routes@list');
Route::post('/bread_model_variables/create', 'bread_controller_routes@create');
Route::post('/bread_model_variables/update', 'bread_controller_routes@update');
Route::post('/bread_model_variables/destroy', 'bread_controller_routes@destroy');
