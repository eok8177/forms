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

mix.options({
    processCssUrls: false
});

mix.webpackConfig({
    output: {
        // Chunks in webpack
        publicPath: '/',
        chunkFilename: 'js/components/[name].js',
    },
});

mix
   .js('resources/js/admin.js', 'public/js')
   .js('resources/js/app.js', 'public/js')
   // .sass('resources/sass/app.scss', 'public/css')
   // .sass('resources/sass/admin.scss', 'public/css')
   // .sass('public/css/style.scss', 'public/css')
   ;
