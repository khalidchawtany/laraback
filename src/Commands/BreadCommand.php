<?php

namespace Kjdion84\Laraback\Commands;

use DirectoryIterator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class BreadCommand extends Command
{
    protected $signature = 'make:bread {file} '
        .'{--m|migration} '
        .'{--f|factory} '
        .'{--s|seeder} '
        .'{--a|model} '
        .'{--w|routes} '
        .'{--r|request} '
        .'{--c|controller} '
        .'{--g|permissions} '
        .'{--p|view} '
        .'{--i|home_icon} '
        .'{--d|dashboard} '
        .'{--j|jmodel} '
        .'{--jroute} '
        .'{--jdb} '
        .'{--jview} '
        .'{--jnavbar} '
        .'{--jperm} '
        .'{--l|navbar}';
    // php artisan make:bread resources/bread/UsedCar.php
    protected $description = 'Generate BREAD files.';
    public $options = [];
    public $replace = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        if (file_exists($this->argument('file'))) {
            // set options and generate
            $this->options = include $this->argument('file');
            $this->setReplaceModel()->setReplaceAttributes()->generate();

            // ask to migrate
            if ($this->option('migration') && $this->ask('Migrate now? [y/n]') == 'y') {
                Artisan::call('migrate');
                $this->info('Migration complete!');
            }

            // output success message
            $this->info($this->replace['model']['bread_model_class'] . ' BREAD generated!');
        }
        else {
            // file does not exist, show error
            $this->error('Error: ' . $this->argument('file') . ' does not exist.');
        }
    }

    public function setReplaceModel()
    {
        $model = basename($this->argument('file'), '.php');
        $controller = $model.'Controller';
        $string = trim(preg_replace('/(?!^)[A-Z]{2,}(?=[A-Z][a-z])|[A-Z][a-z]/', ' $0', $model));

        $this->replace['model'] = [
            'bread_model_class' => $model,
            'bread_model_variables' => str_replace(' ', '_', strtolower(str_plural($string))),
            'bread_model_variable' => str_replace(' ', '_', strtolower($string)),
            'bread_model_strings' => str_plural($string),
            'bread_model_classes' => str_plural($model),
            'bread_model_string' => $string,
            '/* bread_model_namespace */' => 'namespace ' . $this->replaceNamespace($this->options['paths']['model']) . ';',
            '/* bread_model_use */' => 'use '. $this->replaceNamespace($this->options['paths']['model']) . '\\' . $model . ';',
            'bread_controller_class' => $controller,
            'bread_controller_view' => $this->replaceView($this->options['paths']['views']),
            'bread_controller_routes' => ltrim(str_replace('App\\Http\\Controllers', '', $this->replaceNamespace($this->options['paths']['controller'])) . '\\' . $controller, '\\'),
            '/* bread_controller_namespace */' => 'namespace ' . $this->replaceNamespace($this->options['paths']['controller']) . ';',
            '/* bread_request_namespace */' => 'namespace ' . $this->replaceNamespace($this->options['paths']['request']) . '\\' . str_replace(' ', '',str_plural($string)) . ';',
        ];

        return $this;
    }

    public function replaceNamespace($path)
    {
        $namespace = str_replace('app', 'App', $path);
        $namespace = str_replace('/', '\\', $namespace);

        return $namespace;
    }

    public function replaceView($path)
    {
        $view = str_replace('resources/views', '', $path);
        $view = str_replace('/', '.', $view) . '.';

        return ltrim($view, '.');
    }

    public function setReplaceAttributes()
    {
        $replace = [];

        foreach ($this->options['attributes'] as $name => $options) {
            // schema
            if (isset($options['schema'])) {
                $replace['/* bread_schema */'][] = $this->replaceAttribute('database/schema.php', $name, $options);
            }

            // replace factory template with the factory/faker.php for each attribute
            if (isset($options['factory'])) {
                $replace['/* bread_factory */'][] = $this->replaceAttribute('factory/faker.php', $name, $options);
            } else if (isset($options['foreign'])) {
                $replace['/* bread_factory */'][] = $this->replaceAttribute('factory/faker_foreign.php', $name, $options);
            }

            // set foreing key
            if (!isset($options['foreign'])) {
                $options['foreign'] = '';
            } else {
                $options['foreign'] =  '$table->'.$options['foreign'] . ';';
            }
            $replace['/* bread_foreign */'][] = $this->replaceAttribute('database/foreign.php', $name, $options);

            // input
            if (isset($options['input'])) {
                foreach (['add', 'edit'] as $action) {
                    $replace['<!-- bread_input_' . $action . ' -->'][] = $this->replaceAttribute('views/input/' . $action . '/' . $this->replaceInput($options) . '.blade.php', $name, $options);
                }
            }

            // rule
            foreach (['store', 'update'] as $action) {
                if (isset($options['rule_' . $action])) {
                    $replace['/* bread_rule_' . $action . ' */'][] = $this->replaceAttribute('requests/rule/' . $action . '.php', $name, $options);
                }
            }

            // datatable
            if (isset($options['datatable']) && $options['datatable']) {
                $replace['<!-- bread_datatable_heading -->'][] = $this->replaceAttribute('views/datatable/heading.blade.php', $name, $options);
                $replace['/* bread_datatable_column */'][] = $this->replaceAttribute('views/datatable/column.blade.php', $name, $options);
            }

            // set field for the datagrid
            if (isset($options['datagrid_column'])) {
                $replace['/* bread_datagrid_column */'][] = $this->replaceAttribute('views/components/field.blade.php', $name, $options);
            }

            // set the router import and set the router route
            $replace['/* bread_js_router_import */'][] = $this->replaceAttribute('resources/assets/js/components/router_import.js', $name, $options);
            $replace['/* bread_js_router_route */'][] = $this->replaceAttribute('resources/assets/js/components/router_route.js', $name, $options);

            // set the database import and set the database register
            $replace['/* bread_js_import_model */'][] = $this->replaceAttribute('resources/assets/js/components/database_import.js', $name, $options);
            $replace['/* bread_js_register_model */'][] = $this->replaceAttribute('views/datatable/column.blade.php', $name, $options);

        }

        $replace['/* bread_fillable */'] = implode('", "', array_keys($this->options['attributes']));

        foreach ($replace as $key => $values) {
            $this->replace['attributes'][$key] = trim(is_array($values) ? implode(PHP_EOL, $values) : $values);
        }

        return $this;
    }

    public function replaceAttribute($file, $name, $options)
    {
        $file = base_path($this->options['paths']['stubs']) . '/' . $file;

        if (file_exists($file)) {
            $content = file_get_contents($file);

            // if the last char is a newline remove it
            if (substr($content, -1) == "\n"){
                $content = substr($content, 0, -1);
            }

            foreach ($options as $key => $value) {
                $content = str_replace('bread_attribute_' . $key, $value, $content);
            }

            $content = str_replace('bread_attribute_class_from_foreign_key', str_replace(' ', '', ucwords(str_replace('_', ' ', substr($name, 0,-3)))), $content);
            $content = str_replace('bread_attribute_label', ucwords(str_replace('_', ' ', $name)), $content);
            $content = str_replace('bread_attribute_name', $name, $content);
        }

        return isset($content) ? $content : null;
    }

    public function replaceInput($options)
    {
        $input = isset($options['input']) ? $options['input'] : null;

        if (in_array($input, ['text', 'password', 'email', 'number', 'tel', 'url'])) {
            $input = 'input';
        }
        else if (in_array($input, ['radio', 'checkbox'])) {
            $input = 'check';
        }

        return $input;
    }

    public function hasAnyFlagSet()
    {
        foreach ($this->options() as $option) {
          if($option == true) {
              return true;
          }
        }
        return false;
    }

    public function generate()
    {
        $queryCommand = $this->hasAnyFlagSet();

        if ($this->option('controller') || !$queryCommand && $this->confirm('controller ?')) {
            // create controller file
            if (!file_exists(base_path($this->options['paths']['controller']))) mkdir(base_path($this->options['paths']['controller']), 0777, true);
            $this->createFile('controller/controller.php', base_path($this->options['paths']['controller']) . '/' . $this->replace['model']['bread_controller_class'] . '.php');
        }

        if ($this->option('model') || !$queryCommand && $this->confirm('model ?')) {
            // create model file
            if (!file_exists(base_path($this->options['paths']['model']))) mkdir(base_path($this->options['paths']['model']), 0777, true);
            $this->createFile('model.php', base_path($this->options['paths']['model']) . '/' . $this->replace['model']['bread_model_class'] . '.php');
        }

        if ($this->option('jmodel') || !$queryCommand && $this->confirm('js model ?')) {
            // create js model file
            if (!file_exists(base_path($this->options['paths']['js_model']))) mkdir(base_path($this->options['paths']['js_model']), 0777, true);
            $this->createFile('resources/assets/js/models/model.js', base_path($this->options['paths']['js_model']) . '/' . $this->replace['model']['bread_model_class'] . '.js');
        }

        if ($this->option('jroute') || !$queryCommand && $this->confirm('add route to router js?')) {
            $this->updateJsRouter();
        }

        if ($this->option('jnavbar') || !$queryCommand && $this->confirm('add link to navbar js?')) {
            $this->updateJsNavbar();
        }

        if ($this->option('jperm') || !$queryCommand && $this->confirm('add permissions to permission js?')) {
            $this->updateJsPermissions();
        }

        if ($this->option('jdb') || !$queryCommand && $this->confirm('add db to database js?')) {
            $this->updateJsDb();
        }

        if ($this->option('jview') || !$queryCommand && $this->confirm('add js view?')) {
            // create js views folder if does not exist
            if (!file_exists(base_path($this->options['paths']['js_view'] . '/' . $this->replace['model']['bread_model_classes'])))
                mkdir(base_path($this->options['paths']['js_view'] . '/' . $this->replace['model']['bread_model_classes']), 0777, true);

            // create index file
            $this->createFile('resources/assets/js/views/index.vue',
                base_path($this->options['paths']['js_view']) . '/' . $this->replace['model']['bread_model_classes'] . '/index.vue');
            // create models file
            $this->createFile('resources/assets/js/views/models.vue',
                base_path($this->options['paths']['js_view']) . '/' . $this->replace['model']['bread_model_classes'] . '/' . $this->replace['model']['bread_model_variables'] . '.vue');
        }

        if ($this->option('factory') || !$queryCommand && $this->confirm('factory ?')) {
            // create factory file
            if (!file_exists(base_path($this->options['paths']['factory']))) mkdir(base_path($this->options['paths']['factory']), 0777, true);
            $this->createFile('factory/factory.php', base_path($this->options['paths']['factory']) . '/' . $this->replace['model']['bread_model_class'] . 'Factory.php');
        }

        if ($this->option('seeder') || !$queryCommand && $this->confirm('seeder ?')) {
            // create database seeder file
            if (!file_exists(base_path($this->options['paths']['seed']))) mkdir(base_path($this->options['paths']['seed']), 0777, true);
            $this->createFile('database/table_seeder.php', base_path($this->options['paths']['seed']) . '/' . $this->replace['model']['bread_model_classes'] . 'TableSeeder.php');

            // update database seeder
            $this->updateDatabaseSeeder();
        }


        if ($this->option('migration') || !$queryCommand && $this->confirm('migration ?')) {
            // create migration file
            $this->createFile('database/migration.php', database_path('migrations/' . date('Y_m_d_000000', time()) . '_create_' . $this->replace['model']['bread_model_variables'] . '_table.php'));
        }

        if ($this->option('request') || !$queryCommand && $this->confirm('request ?')) {
            // create requests files
            $this->createRequests();
        }

        if ($this->option('view') || !$queryCommand && $this->confirm('view ?')) {
            // create view files
            $this->createViews();
        }

        if ($this->option('navbar') || !$queryCommand && $this->confirm('add to navbar ?')) {
            // add menu item to layout navbar
            $this->updateNavbar();
        }

        if ($this->option('dashboard') || !$queryCommand && $this->confirm('add to dashboard ?')) {
            // add dock item to layout dashboard
            $this->updateDashboard();
        }

        if ($this->option('home_icon') || !$queryCommand && $this->confirm('add home icon ?')) {
            // append home icon
            $this->updateHomeIcon();
        }

        if ($this->option('permissions') || !$queryCommand && $this->confirm('add permissions ?')) {
            // append permissions to the permissions file
            $this->updatePermissions();
        }

        if ($this->option('routes') || !$queryCommand && $this->confirm('add routes ?')) {
            // append routes to web
            $this->updateRoutes();
        }
    }

    public function createFile($file, $target)
    {
        $file = base_path($this->options['paths']['stubs']) . '/' . $file;

        if (file_exists($file)) {
            file_put_contents($target, $this->replaceContent($file));
            $this->line('Created file: ' . $target);
        }
    }

    public function updateDatabaseSeeder()
    {
        $file = base_path($this->options['paths']['stubs']) . '/database/dbseeder.php';
        //If no navbar defined return
        if(! array_key_exists ( 'seed', $this->options['paths'] ) )
        {
            return;
        }
        $target = base_path($this->options['paths']['seed']. '/DatabaseSeeder.php');
        //$hook = '/* bread_dbseeder */';
$hook = '    }
}';

        if (file_exists($file) && file_exists($target)) {
            $file_content = $this->replaceContent($file);
            $target_content = file_get_contents($target);

            if (strpos($target_content, $file_content) === false) {
                file_put_contents($target, str_replace($hook, $file_content . $hook  , $target_content));
                $this->line('Updated file: ' . $target);
            }
        }
    }


    public function createRequests()
    {
        $requests_folder = base_path($this->options['paths']['stubs']) . '/requests';

        if (file_exists($requests_folder)) {
            $requests = new DirectoryIterator($requests_folder);
            $target_folder = base_path($this->options['paths']['request']) . '/' . $this->replace['model']['bread_model_classes'];

            // create target folder if it doesn't exist
            if (!file_exists($target_folder)) {
                mkdir($target_folder, 0777, true);
            }

            // loop through all request stubs and create
            foreach ($requests as $request) {
                if (!$request->isDot() && !$request->isDir()) {
                    $this->createFile('requests/' . $request->getFilename(),
                        $target_folder . '/' .substr($request->getFilename(),0,-4) . $this->replace['model']['bread_model_class'] . '.php');
                }
            }
        }
    }

    public function createViews()
    {
        $views_folder = base_path($this->options['paths']['stubs']) . '/views';

        if (file_exists($views_folder)) {
            $views = new DirectoryIterator($views_folder);
            $target_folder = base_path($this->options['paths']['views']) . '/' . $this->replace['model']['bread_model_variables'];

            // create target folder if it doesn't exist
            if (!file_exists($target_folder)) {
                mkdir($target_folder, 0777, true);
            }

            // loop through all view stubs and create
            foreach ($views as $view) {
                if (!$view->isDot() && !$view->isDir()) {
                    $this->createFile('views/' . $view->getFilename(), $target_folder . '/' . $view->getFilename());
                }
            }
        }
    }

    public function createJsViews()
    {
        $js_views_folder = base_path($this->options['paths']['stubs']) . '/jsviews';

        if (file_exists($js_views_folder)) {
            $views = new DirectoryIterator($js_views_folder);
            $target_folder = base_path($this->options['paths']['jsviews']) . '/' . $this->replace['model']['bread_model_variables'];

            // create target folder if it doesn't exist
            if (!file_exists($target_folder)) {
                mkdir($target_folder, 0777, true);
            }

            // loop through all view stubs and create
            foreach ($views as $view) {
                if (!$view->isDot() && !$view->isDir()) {
                    $this->createFile('views/' . $view->getFilename(), $target_folder . '/' . $view->getFilename());
                }
            }
        }
    }

    public function updateDashboard()
    {
        //If no navbar defined return
        if(! array_key_exists ( 'dashboard', $this->options['paths'] ) )
        {
            return;
        }
        $file = base_path($this->options['paths']['stubs']) . '/views/components/dashboard.blade.php';
        $target = base_path($this->options['paths']['dashboard']);
        $hook = '<!-- bread_dashboard -->';
        $this->updateFileContent($target, $hook, $file);
    }


    public function updateNavbar()
    {
        //If no navbar defined return
        if(! array_key_exists ( 'navbar', $this->options['paths'] ) )
        {
            return;
        }
        $file = base_path($this->options['paths']['stubs']) . '/views/components/navbar.blade.php';
        $target = base_path($this->options['paths']['navbar']);
        $hook = '<!-- bread_navbar -->';

        $this->updateFileContent($target, $hook, $file);
    }

    public function updatePermissions()
    {
        //If no permissions defined return
        if(! array_key_exists( 'permissions', $this->options['paths'] )) {
            return;
        }
        $file = base_path($this->options['paths']['stubs']) . '/views/components/permissions.blade.php';
        $target = base_path($this->options['paths']['permissions']);
        $hook = '<!-- bread_permissions -->';
        $this->updateFileContent($target, $hook, $file);
    }

    public function updateJsRouter()
    {
        //If no home path defined return
        if(! array_key_exists( 'js_router', $this->options['paths'] )) {
            return;
        }
        $target = base_path($this->options['paths']['js_router']);

        // set import
        $hook = '/* bread_js_router_import */';
        $file = base_path($this->options['paths']['stubs']) . '/resources/assets/js/components/router_import.js';
        $this->updateFileContent($target, $hook, $file);

        // set route
        $hook = '/* bread_js_router_route */';
        $file = base_path($this->options['paths']['stubs']) . '/resources/assets/js/components/router_route.js';
        $this->updateFileContent($target, $hook, $file);
    }

    public function updateJsPermissions()
    {
        //If no home path defined return
        if(! array_key_exists( 'js_permissions', $this->options['paths'] )) {
            return;
        }
        $target = base_path($this->options['paths']['js_permissions']);
        $hook = '/* bread_js_permissions */';

        $file = base_path($this->options['paths']['stubs']) . '/resources/assets/js/components/permissions.js';
        $this->updateFileContent($target, $hook, $file);
    }

    public function updateJsNavbar()
    {
        //If no home path defined return
        if(! array_key_exists( 'js_navbar', $this->options['paths'] )) {
            return;
        }
        $target = base_path($this->options['paths']['js_navbar']);
        $hook = '/* bread_js_navbar_link */';
        $file = base_path($this->options['paths']['stubs']) . '/resources/assets/js/components/navbar.js';
        $this->updateFileContent($target, $hook, $file);
    }

    public function updateJsDb()
    {
        //If no home path defined return
        if(! array_key_exists( 'js_db', $this->options['paths'] )) {
            return;
        }
        $target = base_path($this->options['paths']['js_db']);

        // import model in to databases.js
        $hook = '/* bread_js_import_model */';
        $file = base_path($this->options['paths']['stubs']) . '/resources/assets/js/components/database_import.js';
        $this->updateFileContent($target, $hook, $file);

        // register database
        $hook = '/* bread_js_register_model */';
        $file = base_path($this->options['paths']['stubs']) . '/resources/assets/js/components/database_register.js';
        $this->updateFileContent($target, $hook, $file);
    }
    public function updateHomeIcon()
    {
        //If no home path defined return
        if(! array_key_exists( 'home_icon', $this->options['paths'] )) {
            return;
        }
        $target = base_path($this->options['paths']['home_icon']);
        $hook = '<!-- bread_home_icon -->';
        $file = base_path($this->options['paths']['stubs']) . '/views/components/home_icon.blade.php';
        $this->updateFileContent($target, $hook, $file);

        //If no home path defined return
        if(! array_key_exists( 'home_icon_css', $this->options['paths'] )) {
            return;
        }
        $target = base_path($this->options['paths']['home_icon_css']);
        $hook = '/* bread_home_icon_css */';
        $file = base_path($this->options['paths']['stubs']) . '/views/components/home_icon_css.blade.php';
        $this->updateFileContent($target, $hook, $file);
    }

    public function updateRoutes()
    {
        $file = base_path($this->options['paths']['stubs']) . '/routes.php';
        $target = base_path($this->options['paths']['routes']);

        if (file_exists($file) && file_exists($target)) {
            $file_content = $this->replaceContent($file);
            $target_content = file_get_contents($target);

            if (strpos($target_content, $file_content) === false) {
                file_put_contents($target, PHP_EOL . PHP_EOL . $file_content, FILE_APPEND);
                $this->line('Updated file: ' . $target);
            }
        }
    }

    public function updateFileContent($target, $hook, $file)
    {
        if (file_exists($file) && file_exists($target)) {
            $file_content = $this->replaceContent($file);
            $target_content = file_get_contents($target);

            if (strpos($target_content, $file_content) === false) {
                file_put_contents($target, str_replace($hook, $file_content . PHP_EOL . $hook , $target_content));
                $this->line('Updated file: ' . $target);
            }
        }
    }

    public function replaceContent($file)
    {
        $content = file_get_contents($file);
        $content = strtr($content, $this->replace['attributes']);
        $content = strtr($content, $this->replace['model']);

        return $content;
    }
}