<?php

return [

    // do not add trailing slashes
    'paths' => [
        'stubs' => 'vendor/kjdion84/laraback/resources/bread/stubs/default',
        'controller' => 'app/Http/Controllers',
        'model' => 'app',
        'views' => 'resources/views',
        'navbar' => 'resources/views/vendor/laraback/layouts/app.blade.php',
        'routes' => 'routes/web.php',
    ],

    // model attribute definitions
    'attributes' => [
        'title' => [
            'schema' => 'string("bread_attribute_name")->unique()',
            'input' => 'text',
            'rule_add' => 'required|unique:bread_model_variables',
            'rule_edit' => 'required|unique:bread_model_variables,bread_attribute_name,$id',
            'datatable' => true,
        ],
        'detail' => [
            'schema' => 'string("bread_attribute_name")',
            'input' => 'text',
            'rule_add' => 'required',
            'rule_edit' => 'required',
            'datatable' => true,
        ],
        'description' => [
            'schema' => 'text("bread_attribute_name")->nullable()',
            'input' => 'textarea',
        ],
    ],

];