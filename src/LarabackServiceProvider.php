<?php

namespace Kjdion84\Laraback;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class LarabackServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // config
        $this->publishes([__DIR__ . '/../config/laraback.php' => config_path('laraback.php')], 'required');

        // database migrations
        Schema::defaultStringLength(191);
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // public assets
        $this->publishes([__DIR__ . '/../public' => public_path('laraback')], 'required');
        $this->publishes([__DIR__ . '/../public' => public_path('laraback')], 'public');

        // bread generator
        if ($this->app->runningInConsole()) {
            $this->commands([Commands\BreadCommand::class]);
        }
        $this->publishes([__DIR__ . '/../resources/bread/Example.php' => resource_path('bread/Example.php')], 'bread_example');
        $this->publishes([__DIR__ . '/../resources/bread/stubs' => resource_path('bread/stubs/default')], 'bread_stubs');

        // views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laraback');
        $this->publishes([__DIR__ . '/../resources/views/layouts/app.blade.php' => resource_path('views/vendor/laraback/layouts/app.blade.php')], 'required');
        $this->publishes([__DIR__ . '/../resources/views' => resource_path('views/vendor/laraback')], 'views');

        // routes
        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        // gate permissions
        $this->gatePermissions();

        // blade directives
        $this->bladeDirectives();
        
        // settings
        $this->settings();
    }

    public function register()
    {
        // merge config
        $this->mergeConfigFrom(__DIR__ . '/../config/laraback.php', 'laraback');
    }

    public function gatePermissions()
    {
        Gate::before(function ($user, $permission) {
            if ($user->hasPermission($permission)) {
                return true;
            }
        });
    }

    public function bladeDirectives()
    {
        Blade::directive('canany', function ($permissions) {
            $permissions = array_map('trim', explode(',', $permissions));
            $conditional = [];

            foreach ($permissions as $permission) {
                $conditional[] = 'Gate::check(' . $permission . ')';
            }

            return '<?php if (' . implode(' || ', $conditional) . '): ?>';
        });
        Blade::directive('endcanany', function () {
            return '<?php endif; ?>';
        });
    }
    
    public function settings()
    {
        if (Schema::hasTable('settings')) {
            foreach (app(config('laraback.models.setting'))->get() as $setting) {
                Config::set('settings.'.$setting->key, $setting->value);
            }
        }
    }
}