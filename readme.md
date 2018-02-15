# Install Laravel

* Create project `laravel new {project_name}`
* Create `utf8mb4_unicode_ci` database
* Create virtual host pointing to `/public`

# Install Laraback

* Require via composer `composer require kjdion84/laraback:"~1.0"`
* Publish required files `php artisan vendor:publish --provider="Kjdion84\Laraback\LarabackServiceProvider" --tag="required"`
* Add `"post-update-cmd": ["php artisan vendor:publish --provider=Kjdion84\\Laraback\\LarabackServiceProvider --tag=public --force"]` to project composer.json `scripts`
* Add `LarabackUser` and `Timezone` trait to `App\User` model
* Uncomment `AuthenticateSession` in `App\Http\Kernel`
* Configure `.env` file
* Migrate `php artisan migrate`
* Remove `app\Http\Controllers\Auth` folder
* Remove `resources/views/welcome.blade.php` file
* Remove `/` route in `routes/web.php`
* Publish BREAD example `php artisan vendor:publish --provider="Kjdion84\Laraback\LarabackServiceProvider" --tag="bread_example"`

# PHPStorm Helpers

* Enable PHPStorm Laravel plugin
* Create [_ide_helper.php](https://gist.githubusercontent.com/barryvdh/5227822/raw/4be028a27c4ec782965bb8f2fdcb4c08c71a441d/_ide_helper.php) file