# Install

* Create project `laravel new {project_name}`
* Create `utf8mb4_unicode_ci` database
* Create virtual host pointing to `/public`
* Enable PHPStorm Laravel plugin
* Create [_ide_helper.php](https://gist.githubusercontent.com/barryvdh/5227822/raw/4be028a27c4ec782965bb8f2fdcb4c08c71a441d/_ide_helper.php) file
* Create `.todo` file
* Require via composer `composer require kjdion84/laraback:"~1.0"`
* Publish required files `php artisan vendor:publish --provider="Kjdion84\Laraback\LarabackServiceProvider" --tag="required"`
* Add `"post-update-cmd": ["php artisan vendor:publish --provider=Kjdion84\\Laraback\\LarabackServiceProvider --tag=public --force"]` to project composer.json scripts
* Add `LarabackUser` trait to `App\User` model
* Uncomment `AuthenticateSession` in `App\Http\Kernel`
* Configure `.env` file
* Migrate `php artisan migrate`
* Remove `/` route in `routes/web.php`
* Remove `app\Http\Controllers\Auth` folder & `resources/views/welcome.blade.php` file
* Empty `public/css/app.css` and `public/css/app.js`
* Publish BREAD example `php artisan vendor:publish --provider="Kjdion84\Laraback\LarabackServiceProvider" --tag="bread_example"`