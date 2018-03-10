<?php

Route::group(['middleware' => 'web'], function () {
    // index
    Route::get('/', config('laraback.controllers.index') . '@index')->name('index');
    Route::get('home', config('laraback.controllers.index') . '@homeRedirect');

    // dashboard
    Route::get('dashboard', config('laraback.controllers.dashboard') . '@index')->name('dashboard');

    // auth
    Route::get('login', config('laraback.controllers.auth') . '@loginForm')->name('login');
    Route::post('login', config('laraback.controllers.auth') . '@login');
    Route::get('logout', config('laraback.controllers.auth') . '@logout')->name('logout');
    Route::get('register', config('laraback.controllers.auth') . '@registerForm')->name('register');
    Route::post('register', config('laraback.controllers.auth') . '@register');
    Route::get('profile', config('laraback.controllers.auth') . '@profileForm')->name('profile');
    Route::patch('profile', config('laraback.controllers.auth') . '@profile');
    Route::get('password/email', config('laraback.controllers.auth') . '@passwordEmailForm')->name('password.email');
    Route::post('password/email', config('laraback.controllers.auth') . '@passwordEmail');
    Route::get('password/reset/{token?}', config('laraback.controllers.auth') . '@passwordResetForm')->name('password.reset');
    Route::post('password/reset', config('laraback.controllers.auth') . '@passwordReset');
    Route::get('password/change', config('laraback.controllers.auth') . '@passwordChangeForm')->name('password.change');
    Route::patch('password/change', config('laraback.controllers.auth') . '@passwordChange');

    // settings
    Route::get('settings', config('laraback.controllers.setting') . '@editForm')->name('settings');
    Route::patch('settings', config('laraback.controllers.setting') . '@edit');

    // role
    Route::get('roles', config('laraback.controllers.role') . '@index')->name('roles');
    Route::get('roles/datatable', config('laraback.controllers.role') . '@indexDatatable')->name('roles.datatable');
    Route::get('roles/add', config('laraback.controllers.role') . '@addModal')->name('roles.add');
    Route::post('roles/add', config('laraback.controllers.role') . '@add');
    Route::get('roles/edit/{id}', config('laraback.controllers.role') . '@editModal')->name('roles.edit');
    Route::patch('roles/edit/{id}', config('laraback.controllers.role') . '@edit');
    Route::get('roles/delete/{id}', config('laraback.controllers.role') . '@deleteModal')->name('roles.delete');
    Route::delete('roles/delete/{id}', config('laraback.controllers.role') . '@delete');

    // user
    Route::get('users', config('laraback.controllers.user') . '@index')->name('users');
    Route::get('users/datatable', config('laraback.controllers.user') . '@indexDatatable')->name('users.datatable');
    Route::get('users/add', config('laraback.controllers.user') . '@addModal')->name('users.add');
    Route::post('users/add', config('laraback.controllers.user') . '@add');
    Route::get('users/edit/{id}', config('laraback.controllers.user') . '@editModal')->name('users.edit');
    Route::patch('users/edit/{id}', config('laraback.controllers.user') . '@edit');
    Route::get('users/password/{id}', config('laraback.controllers.user') . '@passwordModal')->name('users.password');
    Route::patch('users/password/{id}', config('laraback.controllers.user') . '@password');
    Route::get('users/delete/{id}', config('laraback.controllers.user') . '@deleteModal')->name('users.delete');
    Route::delete('users/delete/{id}', config('laraback.controllers.user') . '@delete');

    // activity
    Route::get('activities', config('laraback.controllers.activity') . '@index')->name('activities');
    Route::get('activities/datatable', config('laraback.controllers.activity') . '@indexDatatable')->name('activities.datatable');
    Route::get('activities/data/{id}', config('laraback.controllers.activity') . '@dataModal')->name('activities.data');
    Route::get('activities/user/{id}', config('laraback.controllers.activity') . '@user')->name('activities.user');
    Route::get('activities/user/datatable/{id}', config('laraback.controllers.activity') . '@userDatatable')->name('activities.user.datatable');
});