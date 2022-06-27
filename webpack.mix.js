const mix = require('laravel-mix');
const NodePolyfillPlugin = require("node-polyfill-webpack-plugin");
let path = require('path');

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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .vue()
    .options({
        legacyNodePolyfills: false,
        processCssUrls: false,
        runtimeChunkPath: '.',
        autoprefixe: false,
    })
    .extract(['vue', 'bootstrap-vue', 'vee-validate', 'vue-select'])
    .disableNotifications()
    .webpackConfig({
        plugins: [
            new NodePolyfillPlugin()
        ],
        output: {
            publicPath: '/',
            chunkFilename: 'assets/template/[name].[chunkhash].js',
        },
        resolve: {
            alias: {
                '@': path.resolve('resources')
            }
        }
    })
    .version();
