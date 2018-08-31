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
        'title' => [
            'schema' => 'string("bread_attribute_name")->unique()',
            'input' => 'text',
            'factory' => 'TODO',
            'rule_store' => 'required|unique:bread_model_variables',
            'rule_update' => 'required|unique:bread_model_variables,bread_attribute_name,$id',
            'datatable' => true,
        ],
        'detail' => [
            'schema' => 'string("bread_attribute_name")',
            'input' => 'text',
            'rule_store' => 'required',
            'rule_update' => 'required',
            'datatable' => true,
        ],
        'description' => [
            'schema' => 'text("bread_attribute_name")->nullable()',
            'input' => 'textarea',
        ],
    ],

];