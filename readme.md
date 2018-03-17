Laraback is a backend/admin package for Laravel 5.6 including demo mode, user activity logs, auth integration, roles/permissions, settings, Bootstrap 4 with responsive/collapsing sidebar, FontAwesome 5, Datatables, BREAD command/generator, AJAX forms/validation, & more.

# Demo & Tutorial Videos

* Demo: http://laraback.kjdion.com
* Install & Config: https://youtu.be/zdZLSbbwrF0
* BREAD Command: https://youtu.be/DgC48L662ds

# Installation

* Configure Laravel `.env` file with app name, URL, database, & mail settings
* Require via composer `composer require kjdion84/laraback:"~2.0"`
* Publish required files `php artisan vendor:publish --provider="Kjdion84\Laraback\LarabackServiceProvider" --tag="required"`
* Add `"post-update-cmd": ["php artisan vendor:publish --provider=Kjdion84\\Laraback\\LarabackServiceProvider --tag=public --force"]` to project composer.json `scripts`
* Add `LarabackUser` and `Timezone` trait to `App\User` model
* Add `timezone` fillable to `App\User` model
* Uncomment `AuthenticateSession` in `App\Http\Kernel`
* Migrate `php artisan migrate`
* Remove `app\Http\Controllers\Auth` folder, `resources/views/welcome.blade.php` file, and `/` route in `routes/web.php`
* Publish BREAD example `php artisan vendor:publish --provider="Kjdion84\Laraback\LarabackServiceProvider" --tag="bread_example"`

## Logging In

Now that installation is done, visit the app URL and log in using `admin@example.com` and `admin123` as the password. Change these credentials by clicking on `Admin` in the top-right corner of the dashboard and going to `Edit Profile`.

# Configuration

You can enable/disable the core features inside of `config/laraback.php`:

* `demo`: enable/disable demo mode (only allows login, but still shows buttons & features)
* `controllers.*`: change these if you want the package to use your own controllers
* `models.*`: change these if you want the package to use your own models

## Enabling Demo Features

If you would like a certain feature to be enabled in demo mode, pass `true` as the 2nd parameter in the `validateAjax` function of your controllers.

## Using Custom Classes

When using your own models & controllers, be sure to extend the existing Laraback classes. Then you can easily override any existing method you want.

# Usage

## Settings

See the `default_timezone` setting for an example. 

All settings can be access via `config('settings.KEY)`, where `KEY` is the value of the `key` column in the database.

In order to create new settings, add a new row in the database, and be sure to update the `vendor/laraback/settings/edit.blade.php` view with an input for the new setting. You can also create your own `SettingController` in order to add more validation rules and flexibility.

## Helpers

### `flash($class, $message)`

Flashes a message to the session which will display on the next request via a Bootstrap 4 alert.

* `$class`: the Bootstrap 4 `alert-` class to use e.g. `success`
* `$message`: the message to display in the alert e.g. `User edited!`

### `activity($log, $data = [], $model = null)`

Logs a new activity in the database via the `Activity` model.

* `$log`: the message to log e.g. `Edited User`
* `$data`: an array of data to log e.g. `request()->all()`
* `$model`: the model the activity is being performed on e.g. `App\User`

`$data` and `$model` are both optional.

### `timezones()`

This function will return a nicely named and organized list of PHP timezones along with their UTC offsets. It uses the `timezone_identifiers_list()` function, so DST correction is not an issue.

Object values include `name`, `offset`, and `label` for each timezone.

## Traits

### Timezone

This trait will convert (via accessors) the model `created_at`, `updated_at`, and `deleted_at` attributes to the users timezone.

### LarabackUser

Contains the role, permission, & activity relationships and functions for auth users.

### ValidateAjax

This is similar to Laravels `validate()` method, but it will totally stop an action from occurring if demo mode is enabled. It also returns a proper JSON response for use with the Laraback AJAX form functionality. You should always use `validateAjax()` instead of `validate()` with Laraback.

### Responses

The package controller methods return a JSON response for BREAD operations. This is due to the form validation AJAX. Each JSON key you return has a specific function:

* `redirect`: redirects user to specified URL e.g. `'redirect' => route('index')`
* `flash`: flashes alert briefly using bs4 class e.g. `'flash' => ['success', 'User added!']`
* `dismiss_modal`: closes the current model the form is in
* `reload_page`: reloads the current location
* `reload_datatables`: reloads datatables on the page to display new/updated data

This can be utlized via your controllers like so:

    return response()->json([
        'flash' => ['success', 'User added!'],
        'dismiss_modal' => true,
        'reload_datatables' => true,
    ]);

You can also add your own response keys with jQuery via:

    $(document).ajaxComplete(function (event, xhr, settings) {
        if (xhr.hasOwnProperty('responseJSON') && xhr.responseJSON.hasOwnProperty('my_response_key')) {
            // do stuff with xhr.responseJSON.my_response_key
        }
    });
    
Then you would simply add this to the json array being returned in the controller:

    'my_response_key' => 'My Value',

## BREAD Generator Command

Use `php artisan make:bread {file}` to generate BREAD files e.g.:

    php artisan make:bread resources/bread/MyModel.php

This will generate a controller, model, migration, views, add a navbar menu item, and routes.

You must make sure you create a `resources/bread/MyModel.php` file before running the command, where `MyModel` is the name of the model you want to generate. This model file will contain all of the path & attribute definitions for the model. Check out `vendor/kjdion84/laraback/resources/bread/Example.php` for an example, or publish the example using:

    php artisan vendor:publish --provider="Kjdion84\Laraback\LarabackServiceProvider" --tag="bread_example"

This will create `resources/bread/Example.php`, which you can then use via `php artisan make:bread resources/bread/Example.php`.

### Model Path & Attribute Definitions

The BREAD command requires you to specify model paths & attributes via a PHP file.

#### Paths

Use the paths array to define exactly which paths you want the generator to use for the model:

* `stubs`: the stub template folder to be used when generating e.g. `resources/bread/stubs/mytemplate`
* `controller`: the folder used for the generated controller e.g. `app/Http/Controllers`
* `model`: the folder used for the generated model e.g. `app`
* `views`: the folder used for the generated views e.g. `resources/views`
* `navbar`: the file containing the `<!-- bread_navbar -->` hook which the menu item is placed under e.g. `resources/views/vendor/laraback/layouts/app.blade.php`
* `routes`: the file which generated routes will be appended to e.g. `routes/web.php`

#### Attributes

Attributes are specified in a key value pair, where the key is the name of the attribute and the value is its options. The following options are available per attribute:

* `schema`: methods used for the migration column e.g. `string("bread_attribute_name")->nullable()`
* `input`: input type for forms which can be `text`, `password`, `email`, `number`, `tel`, `url`, `radio`, `checkbox`, `select`, or `textarea`
* `rule_add`: rules used for creating by the controller e.g. `required|unique:bread_model_variables`
* `rule_edit`: rules used for updating by the controller e.g. `required|unique:bread_model_variables,bread_attribute_name,$id` (note `$id`, this is a variable injected into the controller method)
* `datatable`: enable/disable showing this attribute in the index datatable (boolean)

You can also completely remove any option you do not want to use per attribute.

#### Replacement Strings

There are a number of replacement strings you will see in the stub template files and even the BREAD `Example.php` file:

* `bread_attribute_name`: current attribute name e.g. `post_title`
* `bread_attribute_label`: current attribute label (automatically created using the attribute name) e.g. `Post Title`
* `bread_attribute_schema`: current attribute schema e.g. `string("bread_attribute_name")->nullable()`
* `bread_attribute_input`: current attribute input e.g. `textarea`
* `bread_attribute_rule_add`: current attribute create rule e.g. `required|unique:bread_model_variables`
* `bread_attribute_rule_edit`: current attribute update rule e.g. `required|unique:bread_model_variables,bread_attribute_name,$id`
* `bread_model_class`: model class name e.g. `BlogPost`
* `bread_model_variables`: plural model variable name e.g. `blog_posts`
* `bread_model_variable`: singular model variable name e.g. `blog_post`
* `bread_model_strings`: plural model title name e.g. `Blog Posts`
* `bread_model_string`: singular model title name e.g. `Blog Post`
* `/* bread_model_namespace */`: model namespace line e.g. `namespace App\BlogPost;`
* `/* bread_model_use */`: model use line e.g. `use App\BlogPost;`
* `bread_controller_class`: controller class name e.g. `BlogPostController`
* `bread_controller_view`: view path used by controllers e.g. `blog_posts.`
* `bread_controller_routes`: controller path for routes e.g. `Backend\BlogPostController`
* `/* bread_controller_namespace */`: controller namespace line e.g. `namespace App\Http\Controllers;`

You can use any of these replacement strings inside of the stub templates or model attribute definition files you create.

### Custom Stub Templates

You can easily publish the default stub folder to `resources/bread/stubs/default` with:

    php artisan vendor:publish --provider="Kjdion84\Laraback\LarabackServiceProvider" --tag="bread_stubs"

After doing so, simply rename the folder `default` to whatever you want. Now you can modify it to your hearts desires. Just make sure you specify the full path to this new folder in the `paths.stubs` value for any BREAD model file you want to use it with.

# Issues & Support

Use Github issues for bug reports, suggestions, help, & support.

# Donations

* [Patreon](https://www.patreon.com/kjdion84)
* [Paypal](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=kjdion84@gmail.com)