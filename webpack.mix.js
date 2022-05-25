const mix = require('laravel-mix');

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

mix.js([
        'resources/js/app.js',
        'resources/js/init.js',
        './node_modules/datatables.net/js/jquery.dataTables.min.js',
        './node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js',
        './node_modules/datatables.net-responsive/js/dataTables.responsive.min.js',
        './node_modules/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js',
        './node_modules/datatables.net-buttons/js/dataTables.buttons.min.js',
        './node_modules/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js',
        './node_modules/datatables.net-buttons/js/buttons.html5.min.js',
        './node_modules/datatables.net-buttons/js/buttons.flash.min.js',
        './node_modules/datatables.net-buttons/js/buttons.print.min.js',
        './node_modules/datatables.net-buttons/js/buttons.colVis.min.js',
        './node_modules/datatables.net-keytable/js/dataTables.keyTable.min.js'
    ], 'public/js')
    .sass('resources/sass/app.scss', 'public/css');
