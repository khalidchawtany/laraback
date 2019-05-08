<?php

return [

    // do not add trailing slashes
    'paths' => [
        'stubs'       => 'vendor/kjdion84/laraback/resources/bread/stubs/default',
        'controller'  => 'App/Http/Controllers',
        'model'       => 'app',
        'factory'     => 'database/factories',
        'seed'        => 'database/seeds',
        'views'       => 'resources/views',
        'request'     => 'App/Http/Requests',
        'dashboard'   => 'resources/views/layouts/dashboard.blade.php',
        'navbar'      => 'resources/views/vendor/laraback/layouts/app.blade.php',
        'routes'      => 'routes/web.php',
        'permissions' => 'resources/views/user_manager/permissions.blade.php',
        'home_icon'   => 'resources/views/home/index.blade.php'
    ],

    // model attribute definitions
    'attributes' => [
        'name' => [
            'schema'          => "string('bread_attribute_name')->nullable()",
            'input'           => 'text',
            'factory'         => 'name',
            'rule_store'      => 'bail|string',
            'rule_update'     => 'bail|string',
            'datatable'       => true,
            'datagrid_column' => true,
            'rule_store'      => 'bail|date',
            'rule_update'     => 'bail|date',
        ],
        'date_of_birth' => [
            'label' => 'Date of birth',
            'schema'      => "date('bread_attribute_name')->nullable()",
            'input'       => 'text',
            'factory'     => "date()",
            'rule_store'  => 'bail|date|nullable',
            'rule_update' => 'bail|date|nullable',
            'datatable'   => true,
            'datagrid_column' => true,
        ],
        'note' => [
            'schema'      => "text('bread_attribute_name')->nullable()",
            'input'       => 'textarea',
            'factory'     => 'text',
            'rule_store'  => 'bail|string',
            'rule_update' => 'bail|string',
            'datatable'   => true,
            'datagrid_column' => true,
        ],
        'user_id' => [
            'schema'  => "unsignedInteger('bread_attribute_name')",
            'foreign' => "foreign('bread_attribute_name')->references('id')->on('users')"
        ],
    ],

];