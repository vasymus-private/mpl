const mix = require('laravel-mix');
const webpackConfig = require('./webpack.config')
const path = require('path')

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

mix
    .js('resources/js/web/app.js', 'public/js')
    .sass('resources/sass/web/app.scss', 'public/css')

    .js("resources/js/admin/app.js", 'public/_admin/js')
    .sass("resources/sass/admin/app.scss", "public/_admin/css")

    .js('resources/js/admin/client.js', 'public/_admin/js')
    .vue({ runtimeOnly: (process.env.NODE_ENV || 'production') === 'production' })
    .webpackConfig(webpackConfig)
    .alias({
        ziggy: path.resolve('vendor/tightenco/ziggy/dist/vue'),
    })
;

mix.copyDirectory('resources/images/web', 'public/images')
mix.copyDirectory("resources/images/admin", "public/_admin/images")

mix.copyDirectory('resources/fonts', 'public/fonts')

mix.options({
    processCssUrls : false,
});

// mix.webpackConfig({
//     stats: {
//         children: true,
//     }
// });
