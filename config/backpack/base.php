<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Look & feel customizations
    |--------------------------------------------------------------------------
    |
    | Make it yours.
    |
    */

    // Date & Datetime Format Syntax: https://carbon.nesbot.com/docs/#api-localization
    'default_date_format'     => 'D MMM YYYY',
    'default_datetime_format' => 'D MMM YYYY, HH:mm',

    // Direction, according to language
    // (left-to-right vs right-to-left)
    'html_direction' => 'ltr',

    // ----
    // HEAD
    // ----

    // Project name. Shown in the window title.
    'project_name' => 'Call Manager',

    // When clicking on the admin panel's top-left logo/name,
    // where should the user be redirected?
    // The string below will be passed through the url() helper.
    // - default: '' (project root)
    // - alternative: 'admin' (the admin's dashboard)
    'home_link' => '',

    // Content of the HTML meta robots tag to prevent indexing and link following
    'meta_robots_content' => 'noindex, nofollow',

    // ---------
    // DASHBOARD
    // ---------

    // Show "Getting Started with Backpack" info block?
    'show_getting_started' => env('APP_ENV') == 'local',

    // ------
    // STYLES
    // ------

    // CSS files that are loaded in all pages, using Laravel's asset() helper
    'styles' => [
        'packages/backpack/base/css/bundle.css', // has primary color electric purple (backpack default)
        // 'packages/backpack/base/css/blue-bundle.css', // has primary color blue

        // Here's what's inside the bundle:
        // 'packages/@digitallyhappy/backstrap/css/style.min.css',
        // 'packages/animate.css/animate.min.css',
        // 'packages/noty/noty.css',

        // Load the fonts separately (so that you can replace them at will):
        'packages/source-sans-pro/source-sans-pro.css',
        'packages/line-awesome/css/line-awesome.min.css',

        // Example (the fonts above, loaded from CDN instead)
        // 'https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome-font-awesome.min.css',
        // 'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic',

        // Example (load font-awesome instead of line-awesome):
        // 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css',
    ],

    // CSS files that are loaded in all pages, using Laravel's mix() helper
    'mix_styles' => [ // file_path => manifest_directory_path
        // 'css/app.css' => '',
    ],

    // CSS files that are loaded in all pages, using Laravel's @vite() helper
    // Please note that support for Vite was added in Laravel 9.19. Earlier versions are not able to use this feature.
    'vite_styles' => [ // resource file_path
        // 'resources/css/app.css' => '',
    ],
    'breadcrumbs' => true,
    // ------
    // HEADER
    // ------

    // Menu logo. You can replace this with an <img> tag if you have a logo.
    'project_logo'   => '<img src="data:image/png;base64,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" height="50" width="50">',

    'header_class' => 'app-header navbar navbar-color bg-green border-0',
    'body_class' => 'app aside-menu-fixed sidebar-lg-show',
    'sidebar_class' => 'sidebar', // add "bg-white sidebar-pills" for light sidebar
  
   
    // ----
    // BODY
    // ----

    // Body element classes.
    //'body_class' => 'app aside-menu-fixed sidebar-lg-show',
    // Try sidebar-hidden, sidebar-fixed, sidebar-compact, sidebar-lg-show

    // Sidebar element classes.
    //'sidebar_class' => 'sidebar sidebar-pills bg-light',
    // Remove "sidebar-transparent" for standard sidebar look
    // Try "sidebar-light" or "sidebar-dark" for dark/light links
    // You can also add a background class like bg-dark, bg-primary, bg-secondary, bg-danger, bg-warning, bg-success, bg-info, bg-blue, bg-light-blue, bg-indigo, bg-purple, bg-pink, bg-red, bg-orange, bg-yellow, bg-green, bg-teal, bg-cyan

    // ------
    // FOOTER
    // ------

    // Footer element classes.
     'footer_class' => 'app-footer d-none ',
    // hide it with d-none
    // change background color with bg-dark, bg-primary, bg-secondary, bg-danger, bg-warning, bg-success, bg-info, bg-blue, bg-light-blue, bg-indigo, bg-purple, bg-pink, bg-red, bg-orange, bg-yellow, bg-green, bg-teal, bg-cyan, bg-white

    // Developer or company name. Shown in footer.
    'developer_name' => '',

    // Developer website. Link in footer. Type false if you want to hide it.
    'developer_link' => 'http://tabacitu.ro',

    // Show powered by Laravel Backpack in the footer? true/false
    'show_powered_by' => false,

    // -------
    // SCRIPTS
    // -------

    // JS files that are loaded in all pages, using Laravel's asset() helper
    'scripts' => [
        // Backstrap includes jQuery, Bootstrap, CoreUI, PNotify, Popper
        'packages/backpack/base/js/bundle.js',

        // examples (everything inside the bundle, loaded from CDN)
        // 'https://code.jquery.com/jquery-3.4.1.min.js',
        // 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js',
        // 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js',
        // 'https://unpkg.com/@coreui/coreui@2.1.16/dist/js/coreui.min.js',
        // 'https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
        // 'https://unpkg.com/sweetalert/dist/sweetalert.min.js',
        // 'https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js'

        // examples (VueJS or React)
        // 'https://unpkg.com/vue@2.4.4/dist/vue.min.js',
        // 'https://unpkg.com/react@16/umd/react.production.min.js',
        // 'https://unpkg.com/react-dom@16/umd/react-dom.production.min.js',
    ],

    // JS files that are loaded in all pages, using Laravel's mix() helper
    'mix_scripts' => [ // file_path => manifest_directory_path
        // 'js/app.js' => '',
    ],

    // JS files that are loaded in all pages, using Laravel's @vite() helper
    'vite_scripts' => [ // resource file_path
        // 'resources/js/app.js',
    ],

    // -------------
    // CACHE-BUSTING
    // -------------

    // All JS and CSS assets defined above have this string appended as query string (?v=string).
    // If you want to manually trigger cachebusting for all styles and scripts,
    // append or prepend something to the string below, so that it's different.
    'cachebusting_string' => \PackageVersions\Versions::getVersion('backpack/crud'),

    /*
    |--------------------------------------------------------------------------
    | Registration Open
    |--------------------------------------------------------------------------
    |
    | Choose whether new users/admins are allowed to register.
    | This will show the Register button on the login page and allow access to the
    | Register functions in AuthController.
    |
    | By default the registration is open only on localhost.
    */

    'registration_open' => env('BACKPACK_REGISTRATION_OPEN', env('APP_ENV') === 'local'),

    /*
    |--------------------------------------------------------------------------
    | Routing
    |--------------------------------------------------------------------------
    */

    // The prefix used in all base routes (the 'admin' in admin/dashboard)
    // You can make sure all your URLs use this prefix by using the backpack_url() helper instead of url()
    'route_prefix' => 'admin',

    // The web middleware (group) used in all base & CRUD routes
    // If you've modified your "web" middleware group (ex: removed sessions), you can use a different
    // route group, that has all the the middleware listed below in the comments.
    'web_middleware' => 'web',
    // Or you can comment the above, and uncomment the complete list below.
    // 'web_middleware' => [
    //     \App\Http\Middleware\EncryptCookies::class,
    //     \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
    //     \Illuminate\Session\Middleware\StartSession::class,
    //     \Illuminate\View\Middleware\ShareErrorsFromSession::class,
    //     \App\Http\Middleware\VerifyCsrfToken::class,
    // ],

    // Set this to false if you would like to use your own AuthController and PasswordController
    // (you then need to setup your auth routes manually in your routes.php file)
    // Warning: if you disable this, the password recovery routes (below) will be disabled too!
    'setup_auth_routes' => true,

    // Set this to false if you would like to skip adding the dashboard routes
    // (you then need to overwrite the login route on your AuthController)
    'setup_dashboard_routes' => true,

    // Set this to false if you would like to skip adding "my account" routes
    // (you then need to manually define the routes in your web.php)
    'setup_my_account_routes' => true,

    // Set this to false if you would like to skip adding the password recovery routes
    // (you then need to manually define the routes in your web.php)
    'setup_password_recovery_routes' => true,

    /*
    |--------------------------------------------------------------------------
    | Security
    |--------------------------------------------------------------------------
    */

    // Backpack will prevent visitors from requesting password recovery too many times
    // for a certain email, to make sure they cannot be spammed that way.
    // How many seconds should a visitor wait, after they've requested a
    // password reset, before they can try again for the same email?
    'password_recovery_throttle_notifications' => 600, // time in seconds

    // How much time should the token sent to the user email be considered valid?
    // After this time expires, user needs to request a new reset token.
    'password_recovery_token_expiration' => 60, // time in minutes

    // Backpack will prevent an IP from trying to reset the password too many times,
    // so that a malicious actor cannot try too many emails, too see if they have
    // accounts or to increase the AWS/SendGrid/etc bill.
    //
    // How many times in any given time period should the user be allowed to
    // attempt a password reset? Take into account that user might wrongly
    // type an email at first, so at least allow one more try.
    // Defaults to 3,10 - 3 times in 10 minutes.
    'password_recovery_throttle_access' => '3,10',

    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    */

    // Fully qualified namespace of the User model
    'user_model_fqn' => config('auth.providers.users.model'),
    // 'user_model_fqn' => App\User::class, // works on Laravel <= 7
    // 'user_model_fqn' => App\Models\User::class, // works on Laravel >= 8

    // The classes for the middleware to check if the visitor is an admin
    // Can be a single class or an array of classes
    'middleware_class' => [
        App\Http\Middleware\CheckIfAdmin::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \Backpack\CRUD\app\Http\Middleware\AuthenticateSession::class,
        \Backpack\CRUD\app\Http\Middleware\UseBackpackAuthGuardInsteadOfDefaultAuthGuard::class,
    ],

    // Alias for that middleware
    'middleware_key' => 'admin',
    // Note: It's recommended to use the backpack_middleware() helper everywhere, which pulls this key for you.

    // Username column for authentication
    // The Backpack default is the same as the Laravel default (email)
    // If you need to switch to username, you also need to create that column in your db
    'authentication_column'      => 'email',
    'authentication_column_name' => 'Email',

    // Backpack assumes that your "database email column" for operations like Login and Register is called "email".
    // If your database email column have a different name, you can configure it here. Eg: `user_mail`
    'email_column' => 'email',

    // The guard that protects the Backpack admin panel.
    // If null, the config.auth.defaults.guard value will be used.
    'guard' => 'backpack',

    // The password reset configuration for Backpack.
    // If null, the config.auth.defaults.passwords value will be used.
    'passwords' => 'backpack',

    // What kind of avatar will you like to show to the user?
    // Default: gravatar (automatically use the gravatar for their email)
    // Other options:
    // - null (generic image with their first letter)
    // - example_method_name (specify the method on the User model that returns the URL)
    'avatar_type' => 'gravatar',

    // Gravatar fallback options are 'identicon', 'monsterid', 'wavatar', 'retro', 'robohash', 'blank'
    // 'blank' will keep the generic image with the user first letter
    'gravatar_fallback' => 'blank',

    /*
    |--------------------------------------------------------------------------
    | Theme (User Interface)
    |--------------------------------------------------------------------------
    */
    // Change the view namespace in order to load a different theme than the one Backpack provides.
    // You can create child themes yourself, by creating a view folder anywhere in your resources/views
    // and choosing that view_namespace instead of the default one. Backpack will load a file from there
    // if it exists, otherwise it will load it from the default namespace ("backpack::").

    'view_namespace' => 'backpack::',

    // EXAMPLE: if you create a new folder in resources/views/vendor/myname/mypackage,
    // your namespace would be the one below. IMPORTANT: in this case the namespace ends with a dot.
    // 'view_namespace' => 'vendor.myname.mypackage.',

    // Tell Backpack to look in more places for component views (like widgets)
    'component_view_namespaces' => [
        'widgets' => [
            'backpack::widgets', // falls back to 'resources/views/vendor/backpack/base/widgets'
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | File System
    |--------------------------------------------------------------------------
    */

    // Backpack\Base sets up its own filesystem disk, just like you would by
    // adding an entry to your config/filesystems.php. It points to the root
    // of your project and it's used throughout all Backpack packages.
    //
    // You can rename this disk here. Default: root
    'root_disk_name' => 'root',

    /*
    |--------------------------------------------------------------------------
    | Backpack Token Username
    |--------------------------------------------------------------------------
    |
    | If you have access to closed-source Backpack add-ons, please provide
    | your token username here, if you're getting yellow alerts on your
    | admin panel's pages. Normally this is not needed, it is
    | preferred to add this as an environment variable
    | (most likely in your .env file).
    |
    | More info and payment form on:
    | https://www.backpackforlaravel.com
    |
    */

    'token_username' => env('BACKPACK_TOKEN_USERNAME', false),
];
