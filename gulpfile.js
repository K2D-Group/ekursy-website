var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.less([
        'backend-proui/backend.less',
        'frontend-proui/frontend.less'
    ], 'public/assets/');

    //mix.styles([
    //    "bootstrap.min.css",
    //    "plugins.css",
    //    "main.css",
    //    "themes.css"
    //], 'public/assets/backend-proui.css', 'resources/assets/backend-proui/css');
    //
    //mix.styles([
    //    "bootstrap.min.css",
    //    "plugins.css",
    //    "main.css",
    //    "themes.css"
    //], 'public/assets/frontend-proui.css', 'resources/assets/frontend-proui/css');
    //
    //mix.styles([
    //    //"bootswatch/flatly.min.css",
    //    "prettify/freshcut.css",
    //    "nano.css",
    //    "codex.css"
    //], 'public/assets/codex.css', 'resources/assets/codex/css');
    //
    //mix.scripts([
    //    "jquery-2.1.1.min.js",
    //    "jquery.nanoscroller.min.js",
    //    "bootstrap.min.js",
    //    "prettify/run_prettify.js",
    //    "codex.js"
    //], 'public/assets/codex.js', 'resources/assets/codex/js');

    //mix.copy('resources/assets/codex/fonts', 'public/fonts');
    //mix.copy('resources/assets/codex/css/bootswatch/flatly.min.css', 'public/assets/bootswatch/flatly.min.css');













    mix.version([
        'public/assets/frontend.css',
        'public/assets/backend.css'
    ]);
});