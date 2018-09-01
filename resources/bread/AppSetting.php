<?php

return [

    // do not add trailing slashes
    'paths' => [
        'stubs'      => 'vendor/kjdion84/laraback/resources/bread/stubs/default',
        'controller' => 'App/Http/Controllers',
        'model'      => 'app',
        'factory'    => 'database/factories',
        'seed'       => 'database/seeds',
        'views'      => 'resources/views',
        'request'    => 'App/Http/Requests',
        'dashboard'  => 'resources/views/layouts/dashboard.blade.php',
        'navbar'     => 'resources/views/vendor/laraback/layouts/app.blade.php',
        'routes'     => 'routes/web.php',
    ],

    // model attribute definitions
    'attributes' => [
        'name' => [
            'schema'      => "string('bread_attribute_name')->nullable()",
            'input'       => 'text',
            'factory'     => 'name',
            'rule_store'  => 'bail|string',
            'rule_update' => 'bail|string',
            'datatable'   => true,
        ],
        'value' => [
            'schema'      => "text('bread_attribute_name')->nullable",
            'input'       => 'text',
            'factory'     => 'text',
            'rule_store'  => 'bail|string',
            'rule_update' => 'bail|string',
            'datatable'   => true,
        ],
        'user_id' => [
            'schema'  => "unsignedInteger('bread_attribute_name')",
            'input'   => 'textarea',
            'foreign' => "foreign('user_id')->references('id')->on('users')"
        ],
    ],

];