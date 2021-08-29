let mix = require('laravel-mix');
var LiveReloadPlugin = require('webpack-livereload-plugin');


/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */



mix.webpackConfig({
    plugins: [
        new LiveReloadPlugin()
    ]
});

mix.js('resources/assets/doorder_app/js/doorder_app.js', 'public/js')
    .js('resources/assets/garden_help_app/js/garden_help_app.js', 'public/js')
   .sass('resources/assets/doorder_app/sass/doorder_app.scss', 'public/css')
   .sass('resources/assets/garden_help_app/sass/garden_help_app.scss', 'public/css')
	.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');
