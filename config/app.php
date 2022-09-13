<?php

use App\Carbon\RkCarbon;
use App\Jobs\Agency\CreateAgency;
use App\Jobs\Agency\DeleteAgency;
use App\Jobs\Agency\UpdateAgency;
use App\Jobs\AssignDriverToRoute;
use App\Jobs\AssignRecipientToRoute;
use App\Jobs\DeassignDriverFromRoute;
use App\Jobs\DeassignRecipientFromRoute;
use App\Jobs\Driver\CreateDriver;
use App\Jobs\Driver\DeleteDriver;
use App\Jobs\Driver\UpdateDriver;
use App\Jobs\Person\CreatePerson;
use App\Jobs\Person\DeletePerson;
use App\Jobs\Person\UpdatePerson;
use App\Jobs\Recipient\CreateRecipient;
use App\Jobs\Recipient\DeleteRecipient;
use App\Jobs\Recipient\PauseRecipient;
use App\Jobs\Recipient\UnpauseRecipient;
use App\Jobs\Recipient\UpdateRecipient;
use App\Jobs\ReleaseDriverFromRoute;
use App\Jobs\ReleaseRecipientFromRoute;
use App\Jobs\Route\CreateRoute;
use App\Jobs\Route\DeleteRoute;
use App\Jobs\Route\UpdateRoute;
use Illuminate\Support\Facades\Facade;

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    'asset_url' => env('ASSET_URL'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'UTC',
    // 'timezone' => 'America/New_York',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Faker Locale
    |--------------------------------------------------------------------------
    |
    | This locale will be used by the Faker PHP library when generating fake
    | data for your database seeds. For example, this will be used to get
    | localized telephone numbers, street address information and more.
    |
    */

    'faker_locale' => 'en_US',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,

        App\Providers\RepositoryServiceProvider::class,
        App\Providers\DataTableServiceProvider::class,
        OwenIt\Auditing\AuditingServiceProvider::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => Facade::defaultAliases()->merge([
        // 'ExampleClass' => App\Example\ExampleClass::class,
    ])->toArray(),

    'job_key_names' => [
        'recipient:create' => CreateRecipient::class,
        'recipient:update' => UpdateRecipient::class,
        'recipient:destroy' => DeleteRecipient::class,
        'recipient:assign' => AssignRecipientToRoute::class,
        'recipient:release' => ReleaseRecipientFromRoute::class,

        'driver:create' => CreateDriver::class,
        'driver:update' => UpdateDriver::class,
        'driver:destroy' => DeleteDriver::class,
        'driver:assign' => AssignDriverToRoute::class,
        'driver:release' => ReleaseDriverFromRoute::class,

        'person:create' => CreatePerson::class,
        'person:update' => UpdatePerson::class,
        'person:destroy' => DeletePerson::class
    ],

    'job_classes' => [
        'recipient' => [
            'create' => CreateRecipient::class,
            'update' => UpdateRecipient::class,
            'destroy' => DeleteRecipient::class,
            'pause' => PauseRecipient::class,
            'unpause' => UnpauseRecipient::class,

            'assign' => AssignRecipientToRoute::class,
            'deassign' => DeassignRecipientFromRoute::class
        ],

        'driver' => [
            'create' => CreateDriver::class,
            'update' => UpdateDriver::class,
            'destroy' => DeleteDriver::class,

            'assign' => AssignDriverToRoute::class,
            'deassign' => DeassignDriverFromRoute::class
        ],

        'person' => [
            'create' => CreatePerson::class,
            'update' => UpdatePerson::class,
            'destroy' => DeletePerson::class
        ],

        'route' => [
            'create' => CreateRoute::class,
            'update' => UpdateRoute::class,
            'destroy' => DeleteRoute::class
        ],

        'agency' => [
            'create' => CreateAgency::class,
            'update' => UpdateAgency::class,
            'destroy' => DeleteAgency::class
        ]
    ],

    'default_settings' => [
        'lock_in_day' => [
            'type' => 'number',
            'value' => 1
        ],
        // 'lock_in_time' => [
        //     'type' => 'date',
        //     'value' => RkCarbon::parse('08:00')
        // ],
        'lock_in_time' => [
            'type' => 'string',
            'value' => '08:00'
        ],

        'lock_out_day' => [
            'type' => 'number',
            'value' => 5
        ],
        'lock_out_time' => [
            'type' => 'string',
            'value' => '17:00'
        ],
        // 'lock_out_time' => [
        //     'type' => 'date',
        //     'value' => RkCarbon::parse('17:00')
        // ],
    ]

];
