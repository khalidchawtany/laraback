<?php

namespace Kjdion84\Laraback\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Kjdion84\Laraback\Traits\FSUtils;
use Kjdion84\Laraback\Traits\OtherUtils;
use Kjdion84\Laraback\Traits\PathUtils;
use Kjdion84\Laraback\Traits\ContentUtils;
use Kjdion84\Laraback\Traits\Generators\ModelGenerator;
use Kjdion84\Laraback\Traits\Generators\ControllerGenerator;

class BreadCommand extends Command
{
    use FSUtils;
    use OtherUtils;
    use PathUtils;
    use ContentUtils;
    use ModelGenerator;
    use ControllerGenerator;

    protected $signature = 'make:bread {file} {--m|migration} {--f|factory} {--s|seeder} {--a|model} {--c|controller} {--g|permissions} {--l|navigation}';

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
            $this->info($this->replace['model']['bread_model_class'].' BREAD generated!');
        } else {
            // file does not exist, show error
            $this->error('Error: '.$this->argument('file').' does not exist.');
        }
    }

    public function generate()
    {
        $this->generateController();

        $this->generateModel();


        if ($this->userWants('factory')) {
            // create factory file
            $this->mkDirFor('factory');
            $this->createFile(
                'factory/factory.php',
                base_path($this->options['paths']['factory']).'/'.$this->replace['model']['bread_model_class'].'Factory.php'
            );
        }

        if ($this->userWants('seeder')) {
            $this->mkDirFor('seed');
            $this->createFile(
                'database/table_seeder.php',
                base_path($this->options['paths']['seed']).'/'.$this->replace['model']['bread_model_classes'].'TableSeeder.php'
            );

            // update database seeder
            $this->updateDatabaseSeeder();
        }

        if ($this->userWants('migration')) {
            // create migration file
            $this->createFile(
                'database/migration.php',
                database_path('migrations/'.date('Y_m_d_000000', time()).'_create_'.$this->replace['model']['bread_model_variables'].'_table.php')
            );
        }

        if ($this->userWants('permissions')) {
            // append permissions to the permissions file
            $this->updatePermissions();
        }
    }

    public function updateDatabaseSeeder()
    {
        $file = base_path($this->options['paths']['stubs']).'/database/dbseeder.php';
        //If no navbar defined return
        if (! array_key_exists('seed', $this->options['paths'])) {
            return;
        }
        $target = base_path($this->options['paths']['seed'].'/DatabaseSeeder.php');
        //$hook = '/* bread_dbseeder */';
        $hook = '    }
}';

        if (file_exists($file) && file_exists($target)) {
            $file_content = $this->replaceContent($file);
            $target_content = file_get_contents($target);

            if (strpos($target_content, $file_content) === false) {
                file_put_contents($target, str_replace($hook, $file_content.$hook, $target_content));
                $this->line('Updated file: '.$target);
            }
        }
    }

    public function updatePermissions()
    {
        $file = base_path($this->options['paths']['stubs']).'/views/components/permissions.blade.php';
        //If no permissions defined return
        if (! array_key_exists('permissions', $this->options['paths'])) {
            return;
        }
        $target = base_path($this->options['paths']['permissions']);
        $hook = '<!-- bread_permissions -->';

        if (file_exists($file) && file_exists($target)) {
            $file_content = $this->replaceContent($file);
            $target_content = file_get_contents($target);

            if (strpos($target_content, $file_content) === false) {
                file_put_contents($target, str_replace($hook, $file_content.PHP_EOL.$hook, $target_content));
                $this->line('Updated file: '.$target);
            }
        } else {
            $this->error('Error: permission files does not exist.');
        }
    }
}
