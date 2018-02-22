const mix = require('laravel-mix');
const webpack = require('webpack');
const tailwindcss = require('tailwindcss');

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
    .options({
        uglify: {
            uglifyOptions: {
                compress: {
                    drop_console: false
                }
            }
        },
        processCssUrls: false,
        postCss: [
            tailwindcss('./tailwind.js'),
        ]
    })
    .setPublicPath('public')
    .js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sourceMaps()
    .copy('public', '../../../public/vendor/ward')
    .version();


mix.webpackConfig({
    plugins: [
        new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/)
    ],
    resolve: {
        alias: {
            'vue$': 'vue/dist/vue.runtime.esm.js'
        }
    }
});