const { mix } = require('laravel-mix');

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

if (mix.inProduction()) {
    mix.version();
    mix.options({
        uglify: {
            uglifyOptions: {
                compress: {
                    drop_console: true
                }
            }
        }
   });
}

mix.js('resources/assets/js/app.js', 'public/js')
    .extract([
        'lodash', 'jquery', 'bootstrap', 'vue', 'axios', 'moment', 'datatables.net', 'datatables.net-bs4', 'datatables.net-plugins/sorting/datetime-moment'
    ])
    .autoload({
        jquery: ['$', 'window.jQuery', 'jQuery', 'jquery'],
    })
   .sass('resources/assets/sass/app.scss', 'public/css')
   .sourceMaps();