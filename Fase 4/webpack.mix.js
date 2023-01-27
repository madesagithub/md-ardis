const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ])
    // Bootstrap
    .copyDirectory('node_modules/bootstrap', 'public/vendor/bootstrap')
    // Bootstrap Icons
    .copyDirectory('node_modules/bootstrap-icons', 'public/vendor/bootstrap-icons')
    // Fontwasome
    .copyDirectory('node_modules/@fortawesome/fontawesome-free', 'public/vendor/fontawesome')
    // SweetAlert2
    .copyDirectory('node_modules/sweetalert2', 'public/vendor/sweetalert2');