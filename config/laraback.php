<?php

return [

    // toggle demo mode
    'demo' => false,

    // classes used
    'controllers' => [
        'activity' => 'Kjdion84\Laraback\Controllers\ActivityController',
        'auth' => 'Kjdion84\Laraback\Controllers\AuthController',
        'dashboard' => 'Kjdion84\Laraback\Controllers\DashboardController',
        'index' => 'Kjdion84\Laraback\Controllers\IndexController',
        'role' => 'Kjdion84\Laraback\Controllers\RoleController',
        'setting' => 'Kjdion84\Laraback\Controllers\SettingController',
        'user' => 'Kjdion84\Laraback\Controllers\UserController',
    ],
    'models' => [
        'activity' => 'Kjdion84\Laraback\Models\Activity',
        'permission' => 'Kjdion84\Laraback\Models\Permission',
        'role' => 'Kjdion84\Laraback\Models\Role',
        'setting' => 'Kjdion84\Laraback\Models\Setting',
    ],

];