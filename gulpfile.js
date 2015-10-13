var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */
  
elixir(function(mix) {
   mix.styles([
        'icons/icomoon/styles.css',
        'minified/bootstrap.min.css',
        'minified/core.min.css',
        'minified/components.min.css',
        'minified/colors.min.css'
    ], 'public/assets/css/public-styles.css')

   	.scripts([
   		'plugins/loaders/pace.min.js',
   		'core/libraries/jquery.min.js',
   		'core/libraries/bootstrap.min.js',
   		'plugins/loaders/blockui.min.js',
   		'core/app.js'
   	], 'public/assets/js/public-js.js');

   // .mix.version('assets/css/public-styles.css');
});
